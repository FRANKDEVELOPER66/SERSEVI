<?php

namespace Controllers;

use Mpdf\Mpdf;
use MVC\Router;
use Model\Recibo;

class ReciboPDFController extends AppController
{

    public static function generar(Router $router): void
    {
        $id = (int) ($_GET['id'] ?? 0);

        if (!$id) {
            http_response_code(400);
            echo 'ID de recibo requerido';
            return;
        }

        ini_set('memory_limit', '256M');

        try {
            $recibo = Recibo::buscarConOrg($id);

            if (!$recibo) {
                http_response_code(404);
                echo 'Recibo no encontrado';
                return;
            }

            $mpdf = new Mpdf([
                'mode'              => 'utf-8',
                'format'            => 'Letter',
                'margin_top'        => 10,
                'margin_bottom'     => 10,
                'margin_left'       => 15,
                'margin_right'      => 15,
                'margin_header'     => 0,
                'margin_footer'     => 0,
                'default_font_size' => 10,
                'default_font'      => 'dejavusans',
                'tempDir'           => sys_get_temp_dir(),
            ]);

            $mpdf->SetTitle('Recibo No. ' . $recibo['numero']);
            $mpdf->SetAuthor($recibo['organizacion'] ?? 'SERSEVI');

            $mpdf->WriteHTML(self::estilos(), \Mpdf\HTMLParserMode::HEADER_CSS);
            $mpdf->WriteHTML(self::htmlRecibo($recibo));

            $nombre = 'Recibo_' . $recibo['numero'] . '_' . date('Ymd') . '.pdf';

            header('Content-Type: application/pdf');
            header('Content-Disposition: inline; filename="' . $nombre . '"');
            header('Cache-Control: private, max-age=0, must-revalidate');

            $mpdf->Output($nombre, \Mpdf\Output\Destination::INLINE);
            exit;
        } catch (\Exception $e) {
            http_response_code(500);
            echo 'Error al generar PDF: ' . $e->getMessage();
        }
    }

    // ── LOGO en base64 ────────────────────────────────────────────
    private static function logoBase64(): string
    {
        $path = $_SERVER['DOCUMENT_ROOT'] . '/' . $_ENV['APP_NAME'] . '/public/images/SERSEVI.jpeg';
        if (!file_exists($path)) return '';
        return 'data:image/jpeg;base64,' . base64_encode(file_get_contents($path));
    }

    // ── HTML DEL RECIBO ───────────────────────────────────────────
    private static function htmlRecibo(array $r): string
    {
        $fmtDate = fn($d) => date('d/m/Y', strtotime($d));
        $formatoQ = fn($v) => 'Q. ' . number_format((float)$v, 2);

        $logo    = self::logoBase64();
        $logoTag = $logo
            ? '<img src="' . $logo . '" style="max-height:65px;max-width:130px;object-fit:contain;">'
            : '';

        $formas   = ['Efectivo', 'Cheque', 'Transferencia'];
        $formaHTML = '';
        foreach ($formas as $f) {
            $marcado    = $r['forma_pago'] === $f ? '&#10003;' : '';
            $colorCheck = $r['forma_pago'] === $f ? '#1a2a5e' : 'transparent';
            $formaHTML .= '
            <td style="text-align:center;padding:4px 10px;">
                <table style="margin:0 auto;border-collapse:collapse;">
                    <tr>
                        <td style="width:14px;height:14px;border:1.5pt solid #1a2a5e;
                            background:' . $colorCheck . ';text-align:center;vertical-align:middle;
                            font-size:10pt;color:#fff;font-weight:bold;">' . $marcado . '</td>
                        <td style="padding-left:5px;font-size:9pt;color:#333;">' . $f . '</td>
                    </tr>
                </table>
            </td>';
        }

        $receptor = $r['nombre_receptor'] ?: '';
        $cargo    = $r['cargo_receptor']  ?: '';

        return '
        <div class="recibo-wrap">

            <!-- CABECERA -->
            <table width="100%" style="border-collapse:collapse;background:#1a2a5e;">
                <tr>
                    <td style="padding:12px 16px;width:130px;text-align:left;vertical-align:middle;">
                        ' . $logoTag . '
                    </td>
                    <td style="text-align:center;vertical-align:middle;padding:12px 8px;">
                        <div style="font-size:14pt;font-weight:bold;color:#ffffff;
                            text-transform:uppercase;letter-spacing:2pt;">
                            ' . htmlspecialchars($r['organizacion'] ?? 'SERSEVI') . '
                        </div>
                        <div style="font-size:8.5pt;color:#c9b87a;margin-top:3px;">
                            ' . htmlspecialchars($r['subtitulo'] ?? 'Servicio de Seguridad y Vigilancia Industrial S.A.') . '
                        </div>
                    </td>
                    <td style="text-align:right;vertical-align:middle;padding:12px 16px;white-space:nowrap;">
                        <div style="font-size:18pt;font-weight:900;color:#f0b93a;
                            letter-spacing:3pt;text-transform:uppercase;">RECIBO</div>
                        <div style="font-size:20pt;font-weight:900;color:#ffffff;">
                            No. ' . htmlspecialchars($r['numero']) . '
                        </div>
                    </td>
                </tr>
            </table>

            <!-- FRANJA DORADA -->
            <div style="background:#c9922a;height:4px;"></div>

            <!-- CUERPO -->
            <div style="padding:18px 20px;">

                <!-- Fecha y lugar -->
                <table width="100%" style="border-collapse:collapse;margin-bottom:14px;">
                    <tr>
                        <td style="font-size:9.5pt;">
                            <span style="color:#1a2a5e;font-weight:bold;text-transform:uppercase;
                                font-size:7.5pt;letter-spacing:.5pt;">Fecha: </span>
                            <span style="font-weight:bold;">' . $fmtDate($r['fecha']) . '</span>
                        </td>
                        <td style="text-align:right;font-size:9.5pt;">
                            ' . ($r['lugar'] ? '<span style="color:#1a2a5e;font-weight:bold;
                                text-transform:uppercase;font-size:7.5pt;letter-spacing:.5pt;">Lugar: </span>
                                <span style="font-weight:bold;">' . htmlspecialchars($r['lugar']) . '</span>' : '') . '
                        </td>
                    </tr>
                </table>

                <!-- Datos del pagador -->
                <table width="100%" style="border-collapse:collapse;margin-bottom:10px;">
                    <tr>
                        <td class="td-lbl">Recibimos de:</td>
                        <td class="td-val"><strong>' . htmlspecialchars($r['nombre_pagador']) . '</strong></td>
                    </tr>
                    <tr>
                        <td class="td-lbl">Entidad / Empresa:</td>
                        <td class="td-val">' . htmlspecialchars($r['entidad_pagador'] ?: '—') . '</td>
                    </tr>
                </table>

                <!-- Cantidad en letras -->
                <div class="seccion-box" style="margin-bottom:10px;">
                    <div class="seccion-lbl">La cantidad de:</div>
                    <div class="seccion-val" style="font-size:11pt;font-weight:bold;">
                        ' . htmlspecialchars($r['monto_letras'] ?: '') . '
                    </div>
                </div>

                <!-- Concepto -->
                <div class="seccion-box" style="margin-bottom:14px;">
                    <div class="seccion-lbl">Por concepto de:</div>
                    <div class="seccion-val">' . htmlspecialchars($r['concepto']) . '</div>
                </div>

                <!-- Forma de pago + Total -->
                <table width="100%" style="border-collapse:collapse;margin-bottom:20px;">
                    <tr>
                        <td style="vertical-align:middle;padding:0;">
                            <div style="font-size:7.5pt;font-weight:bold;text-transform:uppercase;
                                color:#1a2a5e;letter-spacing:.5pt;margin-bottom:6px;">Forma de pago:</div>
                            <table style="border-collapse:collapse;">
                                <tr>' . $formaHTML . '</tr>
                            </table>
                        </td>
                        <td style="text-align:right;vertical-align:middle;padding:0;">
                            <table style="border-collapse:collapse;margin-left:auto;
                                border:2pt solid #1a2a5e;border-radius:3pt;">
                                <tr>
                                    <td style="padding:6px 20px;text-align:right;">
                                        <div style="font-size:7.5pt;font-weight:bold;
                                            text-transform:uppercase;color:#1a2a5e;
                                            letter-spacing:.5pt;">Total</div>
                                        <div style="font-size:22pt;font-weight:900;
                                            color:#c9922a;white-space:nowrap;">
                                            ' . $formatoQ($r['monto']) . '
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>

                <!-- Firmas -->
                <table width="100%" style="border-collapse:collapse;margin-top:10px;">
                    <tr>
                        <td style="text-align:center;padding:10px 20px;">
                            <div style="height:45px;border-bottom:1.5pt solid #1a2a5e;"></div>
                            <div style="font-size:9.5pt;font-weight:bold;color:#111;margin-top:5px;">
                                ' . htmlspecialchars($receptor ?: '_________________________') . '
                            </div>
                            ' . ($cargo ? '<div style="font-size:8pt;color:#777;">' . htmlspecialchars($cargo) . '</div>' : '') . '
                            <div style="font-size:7.5pt;color:#999;text-transform:uppercase;
                                letter-spacing:.5pt;margin-top:3px;">Recibí conforme</div>
                        </td>
                        <td style="text-align:center;padding:10px 20px;">
                            <div style="height:45px;border-bottom:1.5pt solid #1a2a5e;"></div>
                            <div style="font-size:9.5pt;font-weight:bold;color:#111;margin-top:5px;">
                                &nbsp;
                            </div>
                            <div style="font-size:7.5pt;color:#999;text-transform:uppercase;
                                letter-spacing:.5pt;margin-top:3px;">Entregué conforme</div>
                        </td>
                    </tr>
                </table>

            </div>

            <!-- PIE -->
            <div style="background:#1a2a5e;color:#c9b87a;text-align:center;
                padding:6px;font-size:8pt;letter-spacing:.5pt;">
                Documento no contable &nbsp;·&nbsp; Comprobante de pago interno
                &nbsp;·&nbsp; SERSEVI &copy; ' . date('Y') . '
            </div>

        </div>';
    }

    // ── CSS ───────────────────────────────────────────────────────
    private static function estilos(): string
    {
        return '
        <style>
            * { box-sizing: border-box; }
            body { font-family: dejavusans, sans-serif; font-size: 10pt; color: #111; margin: 0; padding: 0; }

            .recibo-wrap {
                border: 2pt solid #1a2a5e;
                border-radius: 4pt;
                overflow: hidden;
            }

            .td-lbl {
                background: #eef2f8;
                font-weight: bold;
                color: #1a2a5e;
                font-size: 7.5pt;
                text-transform: uppercase;
                letter-spacing: .5pt;
                padding: 7px 10px;
                border: 1pt solid #c5cfe0;
                width: 28%;
                white-space: nowrap;
            }
            .td-val {
                padding: 7px 10px;
                border: 1pt solid #c5cfe0;
                font-size: 10pt;
                color: #111;
                background: #fff;
            }

            .seccion-box {
                background: #eef2f8;
                border: 1pt solid #c5cfe0;
                border-left: 3pt solid #1a2a5e;
                border-radius: 0 3pt 3pt 0;
                padding: 8px 12px;
            }
            .seccion-lbl {
                font-size: 7.5pt;
                font-weight: bold;
                text-transform: uppercase;
                color: #1a2a5e;
                letter-spacing: .5pt;
                margin-bottom: 4px;
            }
            .seccion-val {
                font-size: 10pt;
                color: #111;
            }
        </style>';
    }
}
