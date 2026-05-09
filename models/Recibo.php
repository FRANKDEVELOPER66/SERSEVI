<?php

namespace Model;

use Model\ActiveRecord;

class Recibo extends ActiveRecord
{

    protected static $tabla      = 'recibos';
    protected static $idTabla    = 'id';

    // ── IMPORTANTE: excluir creado_en y actualizado_en
    // para que MySQL los maneje con DEFAULT CURRENT_TIMESTAMP
    protected static $columnasDB = [
        'id',
        'organizacion_id',
        'numero',
        'fecha',
        'lugar',
        'nombre_pagador',
        'entidad_pagador',
        'concepto',
        'monto',
        'monto_letras',
        'forma_pago',
        'nombre_receptor',
        'cargo_receptor',
        'estado',
        'motivo_anulacion',
    ];

    public $id               = null;
    public $organizacion_id  = 1;
    public $numero           = '';
    public $fecha            = '';
    public $lugar            = '';
    public $nombre_pagador   = '';
    public $entidad_pagador  = '';
    public $concepto         = 'SERVICIOS DE SEGURIDAD';
    public $monto            = 0;
    public $monto_letras     = '';
    public $forma_pago       = 'Efectivo';
    public $nombre_receptor  = '';
    public $cargo_receptor   = '';
    public $estado           = 'emitido';
    public $motivo_anulacion = '';
    // Solo lectura — no se insertan
    public $creado_en        = '';
    public $actualizado_en   = '';

    // ── Validación ─────────────────────────────────────────────────
    public function validar(): array
    {
        static::$alertas = [];

        if (empty(trim($this->nombre_pagador))) {
            self::setAlerta('error', 'El nombre del pagador es requerido.');
        }
        if ((float) $this->monto <= 0) {
            self::setAlerta('error', 'El monto debe ser mayor a 0.');
        }
        if (empty(trim($this->fecha))) {
            self::setAlerta('error', 'La fecha es requerida.');
        }
        if (!in_array($this->forma_pago, ['Efectivo', 'Cheque', 'Transferencia'])) {
            self::setAlerta('error', 'Forma de pago no válida.');
        }

        return static::$alertas;
    }

    // ── Siguiente correlativo ───────────────────────────────────────
    public static function siguienteNumero(int $orgId = 1): string
    {
        $query     = "SELECT COALESCE(MAX(CAST(numero AS UNSIGNED)), 0) + 1 FROM recibos WHERE organizacion_id = $orgId";
        $resultado = self::$db->query($query);
        return str_pad((int) $resultado->fetchColumn(), 3, '0', STR_PAD_LEFT);
    }

    // ── Listar con paginación ───────────────────────────────────────
    public static function listar(int $pagina = 1, int $porPagina = 20): array
    {
        $offset = ($pagina - 1) * $porPagina;
        $total  = (int) self::$db->query("SELECT COUNT(*) FROM recibos WHERE estado = 'emitido'")->fetchColumn();

        $query  = "SELECT r.*, o.nombre AS organizacion
                   FROM recibos r
                   JOIN organizaciones o ON o.id = r.organizacion_id
                   WHERE r.estado = 'emitido'
                   ORDER BY r.fecha DESC, r.id DESC
                   LIMIT $porPagina OFFSET $offset";

        return [
            'datos'      => self::$db->query($query)->fetchAll(\PDO::FETCH_ASSOC),
            'total'      => $total,
            'pagina'     => $pagina,
            'por_pagina' => $porPagina,
            'paginas'    => (int) ceil($total / $porPagina),
        ];
    }

    // ── Buscar por ID con org ───────────────────────────────────────
    public static function buscarConOrg(int $id): ?array
    {
        $query  = "SELECT r.*, o.nombre AS organizacion, o.subtitulo, o.logo_path
                   FROM recibos r
                   JOIN organizaciones o ON o.id = r.organizacion_id
                   WHERE r.id = $id LIMIT 1";
        $row = self::$db->query($query)->fetch(\PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    // ── Anular ─────────────────────────────────────────────────────
    public static function anular(int $id, string $motivo = ''): bool
    {
        $motivo = self::$db->quote($motivo);
        return (bool) self::$db->exec(
            "UPDATE recibos SET estado='anulado', motivo_anulacion=$motivo WHERE id=$id"
        );
    }

    // ── Número duplicado ────────────────────────────────────────────
    public static function numeroExiste(string $numero, int $orgId = 1): bool
    {
        $numero = self::$db->quote($numero);
        return (bool) self::$db->query(
            "SELECT id FROM recibos WHERE numero=$numero AND organizacion_id=$orgId LIMIT 1"
        )->fetch();
    }

    // ── Listar servicios ────────────────────────────────────────────
    public static function servicios(): array
    {
        $query = "SELECT * FROM servicios ORDER BY nombre ASC";
        return self::$db->query($query)->fetchAll(\PDO::FETCH_ASSOC);
    }
}
