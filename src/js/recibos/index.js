import Swal from 'sweetalert2';
import { Modal } from 'bootstrap';

const APP = document.querySelector('meta[name="app-name"]')?.content ?? '';

// ── SweetAlert2 helpers ────────────────────────────────────────
const swalError = (msg) => Swal.fire({
    icon: 'error', title: 'Error', text: msg,
    background: '#0d1830', color: '#fff', confirmButtonColor: '#c9922a',
});
const swalSuccess = (msg) => Swal.fire({
    icon: 'success', title: '¡Listo!', text: msg,
    background: '#0d1830', color: '#fff', confirmButtonColor: '#c9922a',
    timer: 1800, showConfirmButton: false,
});

// ── Número a letras ────────────────────────────────────────────
function numALetras(num) {
    const u = ['', 'uno', 'dos', 'tres', 'cuatro', 'cinco', 'seis', 'siete', 'ocho', 'nueve', 'diez',
        'once', 'doce', 'trece', 'catorce', 'quince', 'dieciséis', 'diecisiete', 'dieciocho', 'diecinueve', 'veinte'];
    const d = ['', '', 'veinti', 'treinta', 'cuarenta', 'cincuenta', 'sesenta', 'setenta', 'ochenta', 'noventa'];
    const c = ['', 'cien', 'doscientos', 'trescientos', 'cuatrocientos', 'quinientos', 'seiscientos', 'setecientos', 'ochocientos', 'novecientos'];
    if (num === 0) return 'Cero quetzales';
    const int_ = Math.floor(num), dec = Math.round((num - int_) * 100);
    let res = '';
    if (int_ >= 1000) { const m = Math.floor(int_ / 1000); res += (m === 1 ? 'mil' : t2(m) + ' mil') + ' '; }
    const r = int_ % 1000;
    if (r >= 100) res += r === 100 ? 'cien ' : c[Math.floor(r / 100)] + ' ';
    const r2 = r % 100;
    if (r2 > 0 && r2 <= 20) res += u[r2] + ' ';
    else if (r2 > 20) { const dv = Math.floor(r2 / 10), uv = r2 % 10; res += d[dv] + (uv ? ' y ' + u[uv] : '') + ' '; }
    res = res.trim() + ' quetzales';
    if (dec > 0) res += ` con ${String(dec).padStart(2, '0')}/100`;
    return res.charAt(0).toUpperCase() + res.slice(1);
    function t2(n) { if (n <= 20) return u[n]; const dv = Math.floor(n / 10), uv = n % 10; return d[dv] + (uv ? ' y ' + u[uv] : ''); }
}

function formatoQ(v) { return 'Q. ' + parseFloat(v).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ','); }

// ── Estilos del recibo (preview en modal) ──────────────────────
function estilosRecibo() {
    return `
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: Arial, sans-serif; font-size: 12px; color: #111; background: #fff; }
        .recibo-wrap { width: 100%; border: 2px solid #1a2a5e; border-radius: 4px; overflow: hidden; }
        .recibo-head { background: #1a2a5e; color: #fff; display: flex; align-items: center; justify-content: space-between; padding: 14px 20px; }
        .recibo-head-logo { max-height: 60px; max-width: 120px; object-fit: contain; }
        .recibo-head-center { text-align: center; flex: 1; padding: 0 16px; }
        .recibo-head-center .empresa { font-size: 16px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; }
        .recibo-head-center .subtitulo { font-size: 11px; color: #c9b87a; margin-top: 3px; }
        .recibo-head-num { text-align: right; }
        .recibo-head-num .titulo-recibo { font-size: 20px; font-weight: 900; letter-spacing: 3px; color: #f0b93a; }
        .recibo-head-num .num { font-size: 22px; font-weight: 900; color: #fff; }
        .recibo-franja { background: #c9922a; height: 4px; }
        .recibo-body { padding: 20px 24px; }
        .recibo-meta { display: flex; justify-content: space-between; margin-bottom: 16px; font-size: 12px; }
        .recibo-meta span { color: #555; }
        .recibo-meta strong { color: #111; }
        .recibo-tabla { width: 100%; border-collapse: collapse; margin-bottom: 14px; }
        .recibo-tabla td { padding: 8px 10px; border: 1px solid #c5cfe0; font-size: 12px; vertical-align: top; }
        .recibo-tabla td.lbl { background: #eef2f8; font-weight: 700; color: #1a2a5e; width: 28%; white-space: nowrap; }
        .recibo-tabla td.val { color: #111; }
        .recibo-letras { background: #eef2f8; border: 1px solid #c5cfe0; border-radius: 4px; padding: 10px 14px; margin-bottom: 14px; }
        .recibo-letras .lbl { font-size: 10px; font-weight: 700; text-transform: uppercase; color: #1a2a5e; margin-bottom: 4px; letter-spacing: 0.5px; }
        .recibo-letras .val { font-size: 13px; font-weight: 600; color: #111; }
        .recibo-concepto { border: 1px solid #c5cfe0; border-radius: 4px; padding: 10px 14px; margin-bottom: 16px; }
        .recibo-concepto .lbl { font-size: 10px; font-weight: 700; text-transform: uppercase; color: #1a2a5e; margin-bottom: 4px; letter-spacing: 0.5px; }
        .recibo-concepto .val { font-size: 13px; color: #111; }
        .recibo-bottom { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .forma-pago { display: flex; gap: 16px; }
        .forma-opt { display: flex; align-items: center; gap: 6px; font-size: 12px; color: #555; }
        .forma-box { width: 14px; height: 14px; border: 1.5px solid #1a2a5e; border-radius: 2px; display: flex; align-items: center; justify-content: center; font-size: 11px; font-weight: 700; color: #1a2a5e; }
        .recibo-total { border: 2px solid #1a2a5e; border-radius: 4px; padding: 8px 20px; text-align: right; }
        .recibo-total .lbl { font-size: 10px; font-weight: 700; text-transform: uppercase; color: #1a2a5e; letter-spacing: 0.5px; }
        .recibo-total .monto { font-size: 20px; font-weight: 900; color: #c9922a; }
        .recibo-firmas { display: grid; grid-template-columns: 1fr 1fr; gap: 40px; margin-bottom: 16px; }
        .firma-bloque { text-align: center; }
        .firma-espacio { height: 50px; border-bottom: 1.5px solid #1a2a5e; margin-bottom: 6px; }
        .firma-nombre { font-size: 12px; font-weight: 600; color: #111; }
        .firma-cargo { font-size: 10px; color: #777; margin-top: 2px; }
        .firma-label { font-size: 10px; color: #999; text-transform: uppercase; letter-spacing: 0.5px; margin-top: 4px; }
        .recibo-pie { background: #1a2a5e; color: #c9b87a; text-align: center; padding: 7px; font-size: 10px; letter-spacing: 0.5px; }
    `;
}

// ── HTML del recibo (preview) ──────────────────────────────────
function buildReceiptHTML(r) {
    const fmtDate = d => { try { const [y, m, dd] = d.split('-'); return `${dd}/${m}/${y}`; } catch { return d; } };
    const formas = ['Efectivo', 'Cheque', 'Transferencia'];
    const formaHTML = formas.map(f => `
        <div class="forma-opt">
            <div class="forma-box">${r.forma_pago === f ? '✓' : ''}</div>
            <span>${f}</span>
        </div>`
    ).join('');

    return `
    <div class="recibo-wrap">
        <div class="recibo-head">
            <div>
                ${r.logo_path
            ? `<img class="recibo-head-logo" src="${r.logo_path}" alt="logo">`
            : `<div style="width:80px"></div>`}
            </div>
            <div class="recibo-head-center">
                <div class="empresa">${r.organizacion ?? 'SERSEVI'}</div>
                <div class="subtitulo">${r.subtitulo ?? 'Servicio de Seguridad y Vigilancia Industrial S.A.'}</div>
            </div>
            <div class="recibo-head-num">
                <div class="titulo-recibo">RECIBO</div>
                <div class="num">No. ${r.numero}</div>
            </div>
        </div>
        <div class="recibo-franja"></div>
        <div class="recibo-body">
            <div class="recibo-meta">
                <div><span>Fecha: </span><strong>${fmtDate(r.fecha)}</strong></div>
                ${r.lugar ? `<div><span>Lugar: </span><strong>${r.lugar}</strong></div>` : ''}
            </div>
            <table class="recibo-tabla">
                <tr>
                    <td class="lbl">Recibimos de:</td>
                    <td class="val"><strong>${r.nombre_pagador}</strong></td>
                </tr>
                <tr>
                    <td class="lbl">Entidad / Empresa:</td>
                    <td class="val">${r.entidad_pagador || '—'}</td>
                </tr>
            </table>
            <div class="recibo-letras">
                <div class="lbl">La cantidad de:</div>
                <div class="val">${r.monto_letras || numALetras(parseFloat(r.monto))}</div>
            </div>
            <div class="recibo-concepto">
                <div class="lbl">Por concepto de:</div>
                <div class="val">${r.concepto}</div>
            </div>
            <div class="recibo-bottom">
                <div>
                    <div style="font-size:10px;font-weight:700;text-transform:uppercase;color:#1a2a5e;margin-bottom:8px;letter-spacing:.5px">Forma de pago:</div>
                    <div class="forma-pago">${formaHTML}</div>
                </div>
                <div class="recibo-total">
                    <div class="lbl">Total</div>
                    <div class="monto">${formatoQ(r.monto)}</div>
                </div>
            </div>
            <div class="recibo-firmas">
                <div class="firma-bloque">
                    <div class="firma-espacio"></div>
                    <div class="firma-nombre">${r.nombre_receptor || '_________________________'}</div>
                    ${r.cargo_receptor ? `<div class="firma-cargo">${r.cargo_receptor}</div>` : ''}
                    <div class="firma-label">Recibí conforme</div>
                </div>
                <div class="firma-bloque">
                    <div class="firma-espacio"></div>
                    <div class="firma-nombre">&nbsp;</div>
                    <div class="firma-label">Entregué conforme</div>
                </div>
            </div>
        </div>
        <div class="recibo-pie">Documento no contable — Comprobante de pago interno &nbsp;|&nbsp; SERSEVI &copy; ${new Date().getFullYear()}</div>
    </div>`;
}

// ── Modal recibo ───────────────────────────────────────────────
let modalInstance = null;

function mostrarModalRecibo(recibo) {
    const bodyEl = document.getElementById('modal-recibo-body');
    const modalEl = document.getElementById('modalRecibo');
    if (!bodyEl || !modalEl) return;

    bodyEl.innerHTML = `<style>${estilosRecibo()}</style>${buildReceiptHTML(recibo)}`;

    if (!modalInstance) {
        modalInstance = new Modal(modalEl);
    }
    modalInstance.show();

    // ── Botón imprimir → PDF server-side ──────────────────────
    document.getElementById('btn-imprimir')?.addEventListener('click', () => {
        window.open(`/${APP}/recibos/pdf?id=${recibo.id}`, '_blank');
    }, { once: true });

    // ── Al cerrar → limpiar y redirigir si es página nuevo ────
    modalEl.addEventListener('hidden.bs.modal', () => {
        bodyEl.innerHTML = '';
        if (window.location.pathname.includes('/recibos/nuevo')) {
            window.location.href = `/${APP}/recibos`;
        }
    }, { once: true });
}

// ── PÁGINA: NUEVO RECIBO ───────────────────────────────────────
const btnGuardar = document.getElementById('btn-guardar');
if (btnGuardar) {

    document.getElementById('f-monto')?.addEventListener('input', () => {
        const v = parseFloat(document.getElementById('f-monto').value) || 0;
        document.getElementById('f-letras').value = numALetras(v);
    });

    btnGuardar.addEventListener('click', async () => {
        const nombre = document.getElementById('f-nombre')?.value.trim();
        const monto = parseFloat(document.getElementById('f-monto')?.value) || 0;
        const concepto = document.getElementById('f-concepto')?.value.trim();
        const fecha = document.getElementById('f-fecha')?.value.trim();

        if (!nombre) { swalError('El nombre del pagador es requerido.'); return; }
        if (!concepto) { swalError('Selecciona un concepto de pago.'); return; }
        if (monto <= 0) { swalError('Ingresa un monto válido mayor a cero.'); return; }
        if (!fecha) { swalError('La fecha es requerida.'); return; }

        const data = {
            numero: document.getElementById('f-numero')?.value.trim(),
            fecha,
            lugar: document.getElementById('f-lugar')?.value.trim(),
            nombre_pagador: nombre,
            entidad_pagador: document.getElementById('f-entidad')?.value.trim(),
            concepto,
            monto,
            monto_letras: document.getElementById('f-letras')?.value.trim(),
            forma_pago: document.querySelector('input[name="forma"]:checked')?.value ?? 'Efectivo',
            nombre_receptor: document.getElementById('f-receptor')?.value.trim(),
            cargo_receptor: document.getElementById('f-cargo')?.value.trim(),
        };

        btnGuardar.disabled = true;
        btnGuardar.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Guardando...';

        try {
            const res = await fetch(`/${APP}/recibos/crear`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data),
            });

            const contentType = res.headers.get('content-type') ?? '';
            if (!contentType.includes('application/json')) {
                console.error('Respuesta no JSON:', await res.text());
                swalError('Error del servidor. Revisá la consola.');
                return;
            }

            const json = await res.json();

            if (json.resultado) {
                await swalSuccess(`Recibo No. ${json.numero} guardado correctamente`);
                const res2 = await fetch(`/${APP}/recibos/ver?id=${json.id}`);
                const json2 = await res2.json();
                if (json2.resultado) mostrarModalRecibo(json2.recibo);
            } else {
                swalError(json.errores?.join('\n') ?? json.mensaje ?? 'Error al guardar');
            }
        } catch (e) {
            swalError('Error de conexión con el servidor.');
            console.error(e);
        } finally {
            btnGuardar.disabled = false;
            btnGuardar.innerHTML = '<i class="bi bi-floppy me-2"></i>Guardar y previsualizar';
        }
    });

    document.getElementById('btn-limpiar')?.addEventListener('click', () => {
        ['f-nombre', 'f-entidad', 'f-lugar', 'f-monto', 'f-letras', 'f-receptor', 'f-cargo']
            .forEach(id => { const el = document.getElementById(id); if (el) el.value = ''; });
        document.getElementById('f-fecha').value = new Date().toISOString().split('T')[0];
        const sel = document.getElementById('f-concepto');
        if (sel && sel.options.length > 1) sel.selectedIndex = 1;
        document.querySelector('input[name="forma"][value="Efectivo"]').checked = true;
    });
}

// ── PÁGINA: HISTORIAL ──────────────────────────────────────────
document.querySelectorAll('.btn-ver').forEach(btn => {
    btn.addEventListener('click', async () => {
        try {
            const res = await fetch(`/${APP}/recibos/ver?id=${btn.dataset.id}`);
            const json = await res.json();
            if (json.resultado) mostrarModalRecibo(json.recibo);
            else swalError('No se encontró el recibo.');
        } catch (e) { swalError('Error de conexión.'); }
    });
});

document.querySelectorAll('.btn-anular').forEach(btn => {
    btn.addEventListener('click', async () => {
        const { value: motivo, isConfirmed } = await Swal.fire({
            title: `Anular recibo No. ${btn.dataset.numero}`,
            input: 'text',
            inputLabel: 'Motivo (opcional)',
            inputPlaceholder: 'Escribe el motivo...',
            background: '#0d1830', color: '#fff',
            confirmButtonColor: '#a82020', cancelButtonColor: '#1a2a5e',
            showCancelButton: true,
            confirmButtonText: 'Anular', cancelButtonText: 'Cancelar',
            inputAttributes: { style: 'background:#1a2a5e;border:1px solid #243580;color:#fff;border-radius:8px' },
        });
        if (!isConfirmed) return;
        try {
            const res = await fetch(`/${APP}/recibos/anular`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id: btn.dataset.id, motivo: motivo ?? '' }),
            });
            const json = await res.json();
            if (json.resultado) { await swalSuccess('Recibo anulado.'); location.reload(); }
            else swalError(json.mensaje ?? 'Error al anular.');
        } catch (e) { swalError('Error de conexión.'); }
    });
});