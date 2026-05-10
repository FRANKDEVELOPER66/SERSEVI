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

    .form-card {
        background: #0d1830;
        border: 1px solid rgba(36, 53, 128, 0.6);
        border-radius: 14px;
        padding: 2rem;
        box-shadow: 0 4px 24px rgba(0, 0, 0, 0.25);
    }

    .form-section-title {
        color: #f0b93a;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1.2px;
        margin-bottom: 1rem;
        padding-bottom: 7px;
        border-bottom: 1px solid rgba(201, 146, 42, 0.2);
    }

    .form-label {
        color: #7eb3ff;
        font-size: 13px;
        margin-bottom: 4px;
    }

    .form-control,
    .form-select {
        background: #132040 !important;
        border: 1px solid #1e3070 !important;
        color: #fff !important;
        border-radius: 9px;
        font-size: 15px;
        transition: border-color 0.2s, box-shadow 0.2s;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #c9922a !important;
        box-shadow: 0 0 0 3px rgba(201, 146, 42, 0.18) !important;
        background: #1a2a5e !important;
    }

    .form-control::placeholder {
        color: #2a3a6a !important;
    }

    .form-control[readonly] {
        background: #0a1020 !important;
        color: #4a6a9a !important;
        cursor: not-allowed;
    }

    .form-select option {
        background: #132040;
        color: #fff;
    }

    .form-check-input:checked {
        background-color: #c9922a;
        border-color: #c9922a;
    }

    .form-check-label {
        color: #c8d8f0;
        font-size: 15px;
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
        padding: 10px 24px;
    }

    .btn-sersevi:hover {
        color: #fff;
        transform: translateY(-2px);
    }

    .btn-sersevi:active {
        transform: translateY(0);
    }

    .btn-volver {
        background: rgba(26, 42, 94, 0.5);
        border: 1px solid #243580;
        color: #7eb3ff;
        border-radius: 10px;
        padding: 9px 18px;
        font-size: 15px;
        transition: all 0.2s;
    }

    .btn-volver:hover {
        background: #1a2a5e;
        color: #fff;
    }

    .divider {
        border-top: 1px solid rgba(26, 42, 94, 0.8);
        margin: 1.3rem 0;
    }

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
            <h4><i class="bi bi-plus-circle me-2" style="color:#f0b93a"></i>Nuevo recibo</h4>
            <span style="color:#7eb3ff;font-size:14px">Servicio de Seguridad y Vigilancia Industrial S.A.</span>
        </div>
    </div>
    <a href="/<?= $_ENV['APP_NAME'] ?>/recibos" class="btn btn-volver">
        <i class="bi bi-arrow-left me-1"></i>Volver
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="form-card">

            <!-- Datos del recibo -->
            <div class="form-section-title"><i class="bi bi-hash me-1"></i>Datos del recibo</div>
            <div class="row mb-3">
                <div class="col-4">
                    <label class="form-label">No. de recibo</label>
                    <input type="text" class="form-control" id="f-numero"
                        value="<?= htmlspecialchars($siguiente ?? '001') ?>" readonly>
                </div>
                <div class="col-4">
                    <label class="form-label">Fecha</label>
                    <input type="date" class="form-control" id="f-fecha" value="<?= date('Y-m-d') ?>">
                </div>
                <div class="col-4">
                    <label class="form-label">Lugar</label>
                    <input type="text" class="form-control" id="f-lugar" placeholder="Ciudad">
                </div>
            </div>

            <div class="divider"></div>

            <!-- Pagador -->
            <div class="form-section-title"><i class="bi bi-person me-1"></i>Datos del pagador</div>
            <div class="mb-3">
                <label class="form-label">Persona / Entidad <span style="color:#e05050">*</span></label>
                <input type="text" class="form-control" id="f-nombre"
                    placeholder="Nombre completo o razón social de quien paga">
            </div>

            <div class="divider"></div>

            <!-- Pago -->
            <div class="form-section-title"><i class="bi bi-cash-coin me-1"></i>Detalle del pago</div>
            <div class="mb-3">
                <label class="form-label">Por concepto de <span style="color:#e05050">*</span></label>
                <select class="form-select" id="f-concepto">
                    <option value="">— Seleccionar servicio —</option>
                    <?php foreach ($servicios ?? [] as $s) : ?>
                        <option value="<?= htmlspecialchars($s['nombre']) ?>"
                            <?= $s['nombre'] === 'SERVICIOS DE SEGURIDAD' ? 'selected' : '' ?>>
                            <?= htmlspecialchars($s['nombre']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Descripción -->
            <div class="mb-3">
                <label class="form-label">Descripción del servicio</label>
                <textarea class="form-control" id="f-descripcion" rows="4"
                    placeholder="Detalle específico del servicio prestado, fechas, ubicación, personal asignado, etc."></textarea>
            </div>

            <div class="row mb-3">
                <div class="col-5">
                    <label class="form-label">Monto (Q) <span style="color:#e05050">*</span></label>
                    <input type="number" class="form-control" id="f-monto"
                        placeholder="0.00" min="0" step="0.01">
                </div>
                <div class="col-7">
                    <label class="form-label">En letras</label>
                    <input type="text" class="form-control" id="f-letras" readonly
                        placeholder="Se genera automático">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Forma de pago</label>
                <div class="d-flex gap-4 mt-1">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="forma" id="r-efectivo" value="Efectivo" checked>
                        <label class="form-check-label" for="r-efectivo">Efectivo</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="forma" id="r-cheque" value="Cheque">
                        <label class="form-check-label" for="r-cheque">Cheque</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="forma" id="r-transferencia" value="Transferencia">
                        <label class="form-check-label" for="r-transferencia">Transferencia</label>
                    </div>
                </div>
            </div>

            <div class="divider"></div>

            <!-- Receptor -->
            <div class="form-section-title"><i class="bi bi-pen me-1"></i>Recibí conforme</div>
            <div class="row mb-4">
                <div class="col-6">
                    <label class="form-label">Nombre de quien recibe</label>
                    <input type="text" class="form-control" id="f-receptor" placeholder="Nombre completo">
                </div>
                <div class="col-6">
                    <label class="form-label">Cargo</label>
                    <input type="text" class="form-control" id="f-cargo" placeholder="Puesto o grado">
                </div>
            </div>

            <div class="d-flex gap-2">
                <button class="btn btn-sersevi" id="btn-guardar">
                    <i class="bi bi-floppy me-2"></i>Guardar y previsualizar
                </button>
                <button class="btn btn-volver" id="btn-limpiar">
                    <i class="bi bi-arrow-counterclockwise me-1"></i>Limpiar
                </button>
            </div>

        </div>
    </div>
</div>

<!-- Modal previsualización -->
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
                    <i class="bi bi-printer me-2"></i>Imprimir / PDF
                </button>
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="<?= asset('build/js/recibos/index.js') ?>"></script>