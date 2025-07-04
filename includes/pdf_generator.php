<?php
require_once 'vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

class PDFGenerator {
    private $dompdf;
    
    public function __construct() {
        $options = new Options();
        $options->set('defaultFont', 'Arial');
        $options->set('isRemoteEnabled', true);
        $options->set('isHtml5ParserEnabled', true);
        
        $this->dompdf = new Dompdf($options);
    }
    
    public function generatePersonajePDF($personaje) {
        $html = $this->getPersonajeHTML($personaje);
        
        $this->dompdf->loadHtml($html);
        $this->dompdf->setPaper('A4', 'portrait');
        $this->dompdf->render();
        
        $filename = 'personaje_' . strtolower(str_replace(' ', '_', $personaje->nombre)) . '.pdf';
        $this->dompdf->stream($filename, array("Attachment" => true));
    }
    
    private function getPersonajeHTML($personaje) {
        $imagen_path = '';
        if($personaje->foto && file_exists(UPLOAD_PATH . $personaje->foto)) {
            $imagen_path = BASE_URL . UPLOAD_PATH . $personaje->foto;
        }
        
        $nivel_texto = $this->getNivelTexto($personaje->nivel);
        $estrellas = str_repeat('⭐', $personaje->nivel);
        
        $html = '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <style>
                @import url("https://fonts.googleapis.com/css2?family=Pirata+One&family=Roboto:wght@300;400;700&display=swap");
                
                body {
                    font-family: "Roboto", sans-serif;
                    margin: 0;
                    padding: 20px;
                    background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
                    color: #333;
                }
                
                .card {
                    background: white;
                    border-radius: 20px;
                    padding: 30px;
                    box-shadow: 0 20px 40px rgba(0,0,0,0.1);
                    max-width: 600px;
                    margin: 0 auto;
                    border: 3px solid #f59e0b;
                }
                
                .header {
                    text-align: center;
                    margin-bottom: 30px;
                    border-bottom: 3px solid #f59e0b;
                    padding-bottom: 20px;
                }
                
                .title {
                    font-family: "Pirata One", cursive;
                    font-size: 36px;
                    color: #1e3a8a;
                    margin: 0;
                    text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
                }
                
                .subtitle {
                    color: #6b7280;
                    font-size: 16px;
                    margin-top: 5px;
                }
                
                .content {
                    display: flex;
                    gap: 30px;
                    align-items: flex-start;
                }
                
                .image-section {
                    flex: 1;
                    text-align: center;
                }
                
                .character-image {
                    width: 200px;
                    height: 200px;
                    border-radius: 50%;
                    border: 5px solid #f59e0b;
                    object-fit: cover;
                    box-shadow: 0 10px 20px rgba(0,0,0,0.2);
                }
                
                .info-section {
                    flex: 1;
                }
                
                .info-item {
                    margin-bottom: 20px;
                    padding: 15px;
                    background: #f8fafc;
                    border-radius: 10px;
                    border-left: 5px solid #f59e0b;
                }
                
                .info-label {
                    font-weight: bold;
                    color: #1e3a8a;
                    font-size: 14px;
                    text-transform: uppercase;
                    letter-spacing: 1px;
                    margin-bottom: 5px;
                }
                
                .info-value {
                    font-size: 18px;
                    color: #374151;
                    font-weight: 500;
                }
                
                .nivel-badge {
                    display: inline-block;
                    background: linear-gradient(45deg, #f59e0b, #fbbf24);
                    color: white;
                    padding: 8px 16px;
                    border-radius: 20px;
                    font-weight: bold;
                    font-size: 16px;
                }
                
                .color-indicator {
                    width: 30px;
                    height: 30px;
                    border-radius: 50%;
                    display: inline-block;
                    border: 3px solid #fff;
                    box-shadow: 0 2px 4px rgba(0,0,0,0.2);
                    vertical-align: middle;
                    margin-left: 10px;
                }
                
                .footer {
                    text-align: center;
                    margin-top: 30px;
                    padding-top: 20px;
                    border-top: 2px solid #e5e7eb;
                    color: #6b7280;
                    font-size: 12px;
                }
                
                .pirate-elements {
                    text-align: center;
                    margin: 20px 0;
                    font-size: 24px;
                }
            </style>
        </head>
        <body>
            <div class="card">
                <div class="header">
                    <h1 class="title">⚓ WANTED ⚓</h1>
                    <p class="subtitle">Ficha de Personaje - One Piece</p>
                </div>
                
                <div class="content">
                    <div class="image-section">';
        
        if($imagen_path) {
            $html .= '<img src="' . $imagen_path . '" alt="' . $personaje->nombre . '" class="character-image">';
        } else {
            $html .= '<div class="character-image" style="background: linear-gradient(45deg, #3b82f6, #1e40af); display: flex; align-items: center; justify-content: center; color: white; font-size: 24px;">
                        <i class="fas fa-user"></i>
                      </div>';
        }
        
        $html .= '
                        <div class="pirate-elements">🏴‍☠️ ⚔️ 🏴‍☠️</div>
                    </div>
                    
                    <div class="info-section">
                        <div class="info-item">
                            <div class="info-label">👤 Nombre</div>
                            <div class="info-value">' . htmlspecialchars($personaje->nombre) . '</div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-label">🎨 Color Representativo</div>
                            <div class="info-value">
                                ' . htmlspecialchars($personaje->color) . '
                                <span class="color-indicator" style="background-color: ' . strtolower($personaje->color) . ';"></span>
                            </div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-label">⚔️ Tipo/Rol</div>
                            <div class="info-value">' . htmlspecialchars($personaje->tipo) . '</div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-label">📊 Nivel de Poder</div>
                            <div class="info-value">
                                <span class="nivel-badge">' . $nivel_texto . '</span>
                                <br><span style="font-size: 20px; margin-top: 5px; display: inline-block;">' . $estrellas . '</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="footer">
                    <p>🏴‍☠️ Generado el ' . date('d/m/Y H:i:s') . ' 🏴‍☠️</p>
                    <p>One Piece Characters Database - Versión ' . APP_VERSION . '</p>
                </div>
            </div>
        </body>
        </html>';
        
        return $html;
    }
    
    private function getNivelTexto($nivel) {
        switch($nivel) {
            case 1: return 'Novato';
            case 2: return 'Principiante';
            case 3: return 'Intermedio';
            case 4: return 'Avanzado';
            case 5: return 'Legendario';
            default: return 'Desconocido';
        }
    }
}
?>
