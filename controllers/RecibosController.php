<?php

namespace Controllers;

use MVC\Router;
use Model\Recibo;

class RecibosController extends AppController
{
    public static function index(Router $router): void
    {
        $pagina    = isset($_GET['pagina']) ? max(1, (int) $_GET['pagina']) : 1;
        $resultado = Recibo::listar($pagina);
        $router->render('recibos/index', [
            'recibos' => $resultado['datos'],
            'total'   => $resultado['total'],
            'pagina'  => $resultado['pagina'],
            'paginas' => $resultado['paginas'],
        ]);
    }

    public static function nuevo(Router $router): void
    {
        $siguiente = Recibo::siguienteNumero();
        $servicios = Recibo::servicios();
        $router->render('recibos/nuevo', [
            'siguiente' => $siguiente,
            'servicios' => $servicios,
        ]);
    }

    public static function crear(Router $router): void
    {
        if (ob_get_level()) ob_clean();
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['resultado' => false, 'mensaje' => 'Método no permitido']);
            return;
        }

        $body = json_decode(file_get_contents('php://input'), true) ?? $_POST;

        $recibo = new Recibo();
        $recibo->sincronizar([
            'organizacion_id' => 1,
            'numero'          => trim($body['numero']          ?? ''),
            'fecha'           => trim($body['fecha']           ?? date('Y-m-d')),
            'lugar'           => trim($body['lugar']           ?? ''),
            'nombre_pagador'  => trim($body['nombre_pagador']  ?? ''),
            'concepto'        => trim($body['concepto']        ?? 'SERVICIOS DE SEGURIDAD'),
            'descripcion'     => trim($body['descripcion']     ?? ''),
            'monto'           => (float) ($body['monto']       ?? 0),
            'monto_letras'    => trim($body['monto_letras']    ?? ''),
            'forma_pago'      => trim($body['forma_pago']      ?? 'Efectivo'),
            'nombre_receptor' => trim($body['nombre_receptor'] ?? ''),
            'cargo_receptor'  => trim($body['cargo_receptor']  ?? ''),
            'estado'          => 'emitido',
        ]);

        $alertas = $recibo->validar();
        if (!empty($alertas['error'])) {
            echo json_encode(['resultado' => false, 'errores' => $alertas['error']]);
            return;
        }

        if (Recibo::numeroExiste($recibo->numero)) {
            $recibo->numero = Recibo::siguienteNumero();
        }

        try {
            $resultado = $recibo->guardar();
            if ($resultado['resultado']) {
                echo json_encode([
                    'resultado' => true,
                    'id'        => $resultado['id'],
                    'numero'    => $recibo->numero,
                    'mensaje'   => 'Recibo guardado correctamente',
                ]);
            } else {
                echo json_encode(['resultado' => false, 'mensaje' => 'Error al guardar el recibo']);
            }
        } catch (\Exception $e) {
            echo json_encode(['resultado' => false, 'mensaje' => $e->getMessage()]);
        }
    }

    public static function ver(Router $router): void
    {
        if (ob_get_level()) ob_clean();
        header('Content-Type: application/json');
        $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
        if (!$id) {
            echo json_encode(['resultado' => false, 'mensaje' => 'ID requerido']);
            return;
        }
        $recibo = Recibo::buscarConOrg($id);
        echo json_encode(
            $recibo
                ? ['resultado' => true,  'recibo'  => $recibo]
                : ['resultado' => false, 'mensaje' => 'No encontrado']
        );
    }

    public static function anular(Router $router): void
    {
        if (ob_get_level()) ob_clean();
        header('Content-Type: application/json');
        $body   = json_decode(file_get_contents('php://input'), true) ?? $_POST;
        $id     = (int) ($body['id']    ?? 0);
        $motivo = trim($body['motivo']  ?? '');
        if (!$id) {
            echo json_encode(['resultado' => false, 'mensaje' => 'ID requerido']);
            return;
        }
        $ok = Recibo::anular($id, $motivo);
        echo json_encode(['resultado' => $ok, 'mensaje' => $ok ? 'Recibo anulado' : 'Error al anular']);
    }

    public static function siguienteNumero(Router $router): void
    {
        if (ob_get_level()) ob_clean();
        header('Content-Type: application/json');
        echo json_encode(['resultado' => true, 'numero' => Recibo::siguienteNumero()]);
    }
}
