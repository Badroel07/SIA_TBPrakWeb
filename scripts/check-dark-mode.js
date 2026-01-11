import fs from 'fs';
import path from 'path';
import { fileURLToPath } from 'url';

const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);

const dirsToCheck = [
    path.join(__dirname, '../resources/views'),
    path.join(__dirname, '../resources/js'),
];

let hasError = false;

function scanDirectory(directory) {
    if (!fs.existsSync(directory)) return;

    const files = fs.readdirSync(directory);

    for (const file of files) {
        const fullPath = path.join(directory, file);
        const stat = fs.statSync(fullPath);

        if (stat.isDirectory()) {
            scanDirectory(fullPath);
        } else if (file.endsWith('.blade.php') || file.endsWith('.js') || file.endsWith('.vue')) {
            const content = fs.readFileSync(fullPath, 'utf-8');
            if (content.includes('dark:')) {
                console.error(`\x1b[31mError: Found "dark:" class in ${fullPath}\x1b[0m`);
                hasError = true;
            }
        }
    }
}

console.log('Scanning for dark mode regressions...');
dirsToCheck.forEach(dir => scanDirectory(dir));

if (hasError) {
    console.error('\n\x1b[31mFAILED: Dark mode classes detected. Please remove them to maintain Light Mode Only policy.\x1b[0m');
    process.exit(1);
} else {
    console.log('\x1b[32mPASSED: No dark mode classes found.\x1b[0m');
    process.exit(0);
}
