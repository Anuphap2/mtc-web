import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                kanit: ['Kanit', ...defaultTheme.fontFamily.sans], // Font Kanit
            },
            colors: {
                // --- ขอเสนอ Theme ใหม่ 'Clean Tech' (เขียว-เทา) ---
                'tech-green': {
                    DEFAULT: '#10B981', // สีเขียวมรกต (emerald-500)
                    dark: '#047857',    // สีเขียวเข้ม (emerald-700)
                },
                'tech-slate': {
                    DEFAULT: '#475569', // สีเทา (slate-600)
                    dark: '#1E293B',    // สีเทาเข้มเกือบดำ (slate-800)
                    light: '#F1F5F9',   // สีเทาอ่อนมาก (slate-100)
                },
                // --- จบส่วน Theme ใหม่ ---


                // --- สีเดิม (เก็บไว้ก่อน) ---
                'mtc-blue': {
                    DEFAULT: '#0D47A1',
                    light: '#1E88E5',
                },
                'mtc-gold': {
                    DEFAULT: '#FFB300',
                },
                'bu-blue': {
                    DEFAULT: '#0057B8',
                },
                'bu-orange': {
                    DEFAULT: '#F26522',
                }
            },
        },
    },

    plugins: [forms],
};