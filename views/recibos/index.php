<style>
    body {
        background: #0a1128 !important;
    }

    .sersevi-header {
        background: linear-gradient(135deg, #1a2a5e 0%, #243580 100%);
        border-radius: 14px;
        padding: 1.4rem 1.8rem;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        box-shadow: 0 4px 24px rgba(26, 42, 94, 0.6);
        border: 1px solid rgba(100, 130, 255, 0.15);
    }

    .sersevi-header h4 {
        color: #fff;
        margin: 0;
        font-weight: 700;
        font-size: 1.4rem;
    }

    .badge-titulo {
        background: rgba(201, 146, 42, 0.15);
        color: #f0b93a;
        border: 1px solid rgba(201, 146, 42, 0.35);
        padding: 6px 16px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 600;
    }

    .btn-sersevi {
        background: linear-gradient(135deg, #c9922a, #e8a830);
        border: none;
        color: #fff;
        font-weight: 700;
        font-size: 15px;
        box-shadow: 0 3px 12px rgba(201, 146, 42, 0.45);
        transition: all 0.2s ease;
        border-radius: 10px;
        padding: 10px 22px;
    }

    .btn-sersevi:hover {
        color: #fff;
        transform: translateY(-2px);
    }

    .btn-sersevi:active {
        transform: translateY(0);
    }

    .dt-wrap {
        background: #0d1830;
        border-radius: 14px;
        border: 1px solid rgba(36, 53, 128, 0.6);
        box-shadow: 0 4px 24px rgba(0, 0, 0, 0.3);
        padding: 1.2rem 1.4rem;
        overflow: hidden;
    }

    /* ── Controles DataTable ── */
    .dataTables_wrapper {
        color: #fff;
    }

    .dataTables_filter label,
    .dataTables_length label {
        color: #7eb3ff;
        font-size: 15px;
        font-weight: 500;
    }

    .dataTables_filter input,
    .dataTables_length select {
        background: #132040 !important;
        border: 1px solid #1e3070 !important;
        color: #fff !important;
        border-radius: 8px;
        padding: 6px 12px;
        font-size: 15px;
        outline: none;
        margin: 0 4px;
    }

    .dataTables_filter input:focus,
    .dataTables_length select:focus {
        border-color: #c9922a !important;
    }

    .dataTables_info {
        color: #7eb3ff;
        font-size: 14px;
    }

    /* ── Paginación ── */
    .dataTables_paginate {
        padding-top: 8px;
    }

    .dataTables_paginate span .paginate_button,
    .dataTables_paginate .paginate_button {
        display: inline-block;
        background: #132040 !important;
        border: 1px solid #1e3070 !important;
        color: #7eb3ff !important;
        border-radius: 7px;
        margin: 0 2px;
        font-size: 14px;
        padding: 5px 13px;
        cursor: pointer;
        transition: all 0.15s;
        text-decoration: none;
    }

    .dataTables_paginate .paginate_button:hover {
        background: #1a2a5e !important;
        color: #fff !important;
        border-color: #c9922a !important;
    }

    .dataTables_paginate .paginate_button.current {
        background: linear-gradient(135deg, #c9922a, #e8a830) !important;
        border-color: #c9922a !important;
        color: #fff !important;
        font-weight: 700;
    }

    .dataTables_paginate .paginate_button.disabled {
        color: #2a3a6a !important;
        background: #0a1020 !important;
        border-color: #1a2a5e !important;
        cursor: default;
    }

    /* ── Tabla ── */
    table.dataTable {
        border-collapse: collapse !important;
        width: 100% !important;
    }

    table.dataTable thead tr {
        background: linear-gradient(135deg, #1a2a5e, #1e3070) !important;
    }

    table.dataTable thead th {
        color: #f0b93a !important;
        font-weight: 700 !important;
        font-size: 14px !important;
        letter-spacing: 0.8px;
        text-transform: uppercase;
        padding: 15px 12px !important;
        border: none !important;
        border-bottom: 2px solid rgba(201, 146, 42, 0.3) !important;
        background: transparent !important;
        cursor: pointer;
    }

    table.dataTable thead th::after,
    table.dataTable thead th::before {
        color: rgba(240, 185, 58, 0.4) !important;
    }

    /* FILAS — todo azul oscuro, sin blanco */
    table.dataTable tbody tr,
    table.dataTable tbody tr.odd,
    table.dataTable tbody tr.even {
        background: #0d1830 !important;
    }

    table.dataTable tbody tr:hover,
    table.dataTable tbody tr.odd:hover,
    table.dataTable tbody tr.even:hover {
        background: #1a2a5e !important;
    }

    table.dataTable tbody td {
        background: inherit !important;
        color: #ffffff !important;
        font-size: 15px !important;
        padding: 14px 12px !important;
        vertical-align: middle !important;
        border-top: 1px solid rgba(26, 42, 94, 0.5) !important;
        border-bottom: none !important;
    }

    /* ── Celdas especiales ── */
    .badge-num {
        background: linear-gradient(135deg, #c9922a, #e8a830);
        color: #fff;
        font-weight: 700;
        padding: 5px 13px;
        border-radius: 8px;
        font-size: 14px;
        box-shadow: 0 2px 8px rgba(201, 146, 42, 0.35);
    }

    .chip-forma {
        background: rgba(201, 146, 42, 0.12);
        color: #f0b93a;
        border: 1px solid rgba(201, 146, 42, 0.3);
        padding: 4px 13px;
        border-radius: 20px;
        font-size: 14px;
        font-weight: 500;
    }

    .monto-val {
        color: #f0b93a !important;
        font-weight: 700 !important;
        font-size: 16px !important;
    }

    .entidad-val {
        color: #7eb3ff !important;
    }

    /* ── Botones acción ── */
    .btn-accion {
        border-radius: 9px;
        padding: 7px 16px;
        font-size: 14px;
        border: none;
        transition: all 0.18s ease;
        cursor: pointer;
        font-weight: 600;
    }

    .btn-accion:active {
        transform: scale(0.93);
    }

    .btn-ver {
        background: #1a2a5e;
        color: #7eb3ff;
        border: 1px solid rgba(80, 120, 220, 0.5);
    }

    .btn-ver:hover {
        background: #243580;
        color: #fff;
        border-color: #7eb3ff;
        transform: translateY(-1px);
    }

    .btn-anular {
        background: rgba(100, 15, 15, 0.5);
        color: #ff8080;
        border: 1px solid rgba(200, 60, 60, 0.4);
    }

    .btn-anular:hover {
        background: rgba(150, 25, 25, 0.65);
        color: #ffb3b3;
        transform: translateY(-1px);
    }

    /* ── Modales ── */
    .modal-sersevi .modal-content {
        background: #0d1830;
        border: 1px solid rgba(36, 53, 128, 0.6);
        border-radius: 16px;
        overflow: hidden;
    }

    .modal-sersevi .modal-header {
        background: linear-gradient(135deg, #1a2a5e, #243580);
        border: none;
        padding: 1.1rem 1.5rem;
    }

    .modal-sersevi .modal-footer {
        background: #0a1128;
        border: none;
        padding: 1rem 1.5rem;
    }

    .modal-sersevi .modal-title {
        color: #fff;
        font-weight: 700;
        font-size: 16px;
    }
</style>

<!-- Header -->
<div class="sersevi-header">
    <div class="d-flex align-items-center gap-3">
        <img src="<?= asset('images/sersevi.png') ?>" height="54" alt="SERSEVI"
            onerror="this.style.display='none'"
            style="filter:drop-shadow(0 2px 8px rgba(0,0,0,0.5))">
        <div>
            <h4><i class="bi bi-receipt me-2" style="color:#f0b93a"></i>Recibos</h4>
            <span style="color:#7eb3ff;font-size:14px">Servicio de Seguridad y Vigilancia Industrial S.A.</span>
        </div>
    </div>
    <div class="d-flex align-items-center gap-3">
        <span class="badge-titulo"><i class="bi bi-archive me-1"></i><?= $total ?? 0 ?> registros</span>
        <a href="/<?= $_ENV['APP_NAME'] ?>/recibos/nuevo" class="btn btn-sersevi">
            <i class="bi bi-plus-circle me-2"></i>Nuevo recibo
        </a>
    </div>
</div>

<!-- Tabla -->
<div class="dt-wrap">
    <table id="tabla-recibos" class="table w-100">
        <thead>
            <tr>
                <th>No.</th>
                <th>Fecha</th>
                <th>Nombre</th>
                <th>Entidad</th>
                <th>Concepto</th>
                <th>Forma</th>
                <th>Monto</th>
                <th class="text-center">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($recibos ?? [] as $r) : ?>
                <tr>
                    <td><span class="badge-num"><?= htmlspecialchars($r['numero']) ?></span></td>
                    <td><?= date('d/m/Y', strtotime($r['fecha'])) ?></td>
                    <td><?= htmlspecialchars($r['nombre_pagador']) ?></td>
                    <td class="entidad-val"><?= htmlspecialchars($r['entidad_pagador'] ?? '—') ?></td>
                    <td><?= htmlspecialchars($r['concepto']) ?></td>
                    <td><span class="chip-forma"><?= htmlspecialchars($r['forma_pago']) ?></span></td>
                    <td class="monto-val">Q. <?= number_format((float)$r['monto'], 2) ?></td>
                    <td class="text-center">
                        <button class="btn-accion btn-ver me-1" data-id="<?= $r['id'] ?>">
                            <i class="bi bi-printer-fill me-1"></i>Ver
                        </button>
                        <button class="btn-accion btn-anular"
                            data-id="<?= $r['id'] ?>"
                            data-numero="<?= htmlspecialchars($r['numero']) ?>">
                            <i class="bi bi-x-circle me-1"></i>Anular
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Modal: ver recibo -->
<div class="modal fade modal-sersevi" id="modalRecibo" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-receipt me-2" style="color:#f0b93a"></i>Vista previa del recibo
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body bg-white rounded-3 m-3 p-4" id="modal-recibo-body"></div>
            <div class="modal-footer">
                <button class="btn btn-sersevi" id="btn-imprimir">
                    <i class="bi bi-printer me-2"></i>Imprimir
                </button>
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal: anular -->
<div class="modal fade modal-sersevi" id="modalAnular" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background:linear-gradient(135deg,#5e1a1a,#7a2020)">
                <h5 class="modal-title"><i class="bi bi-x-circle me-2"></i>Anular recibo</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" style="color:#fff">
                <p style="font-size:15px">¿Deseas anular el recibo <strong id="anular-numero" style="color:#f0b93a"></strong>?</p>
                <label class="form-label" style="color:#7eb3ff;font-size:14px">Motivo (opcional)</label>
                <input type="text" class="form-control"
                    style="background:#1a2a5e;border-color:#243580;color:#fff;font-size:15px"
                    id="anular-motivo" placeholder="Motivo de anulación">
                <input type="hidden" id="anular-id">
            </div>
            <div class="modal-footer">
                <button class="btn" id="btn-confirmar-anular"
                    style="background:linear-gradient(135deg,#8b1a1a,#a82020);color:#fff;border:none;border-radius:9px;font-size:15px;font-weight:600;padding:9px 20px">
                    <i class="bi bi-x-circle me-2"></i>Confirmar anulación
                </button>
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<!-- Solo JS de DataTables, SIN su CSS -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#tabla-recibos').DataTable({
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
            },
            pageLength: 15,
            order: [
                [0, 'desc']
            ],
            stripeClasses: [],
            columnDefs: [{
                orderable: false,
                targets: 7
            }]
        });
    });
</script>

<script src="<?= asset('build/js/recibos/index.js') ?>"></script>