import sharp from 'sharp';
import fs from 'fs';
import path from 'path';

const pwaDir = path.join(process.cwd(), 'public', 'images', 'pwa');

const conversions = [
    { input: 'icon-192.svg', output: 'icon-192.png', size: 192 },
    { input: 'icon-512.svg', output: 'icon-512.png', size: 512 },
    { input: 'icon-maskable-192.svg', output: 'icon-maskable-192.png', size: 192 },
    { input: 'icon-maskable-512.svg', output: 'icon-maskable-512.png', size: 512 },
    { input: 'apple-touch-icon.svg', output: 'apple-touch-icon.png', size: 180 }
];

async function convertIcons() {
    console.log('🔄 Convirtiendo iconos SVG a PNG...\n');
    
    for (const conversion of conversions) {
        const inputPath = path.join(pwaDir, conversion.input);
        const outputPath = path.join(pwaDir, conversion.output);
        
        try {
            console.log(`📦 ${conversion.input} → ${conversion.output} (${conversion.size}x${conversion.size})`);
            
            // Leer SVG
            const svgBuffer = fs.readFileSync(inputPath);
            
            // Convertir a PNG usando sharp
            await sharp(svgBuffer)
                .resize(conversion.size, conversion.size, {
                    fit: 'contain',
                    background: { r: 0, g: 0, b: 0, alpha: 0 }
                })
                .png()
                .toFile(outputPath);
            
            console.log(`   ✅ ${conversion.output} creado\n`);
        } catch (error) {
            console.error(`   ❌ Error al convertir ${conversion.input}:`, error.message);
        }
    }
    
    console.log('✅ Conversión completada');
}

convertIcons().catch(console.error);
