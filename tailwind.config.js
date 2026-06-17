/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        // Premium Navy Blue Palette
        primary: {
          DEFAULT: '#07111F',
          soft: '#0B1F2A',
        },
        accent: {
          DEFAULT: '#1D4ED8',
          soft: '#2563EB',
          hover: '#1E40AF',
        },
        background: {
          DEFAULT: '#F7F3EA',
        },
        surface: {
          DEFAULT: '#FFFFFF',
        },
        text: {
          DEFAULT: '#111827',
          muted: '#6B7280',
        },
        // Legacy colors for backward compatibility
        cream: {
          50: '#faf9f6',
          100: '#f8f5f0',
          200: '#f0ebe3',
          300: '#e8e1d6',
        },
        forest: {
          50: '#f0fdf4',
          100: '#dcfce7',
          500: '#10b981',
          600: '#059669',
          800: '#065f46',
          900: '#0f2d1a',
        },
        midnight: {
          900: '#111827',
          800: '#1f2937',
        },
        sand: {
          100: '#f5f5f4',
          200: '#e7e5e4',
        }
      },
      fontFamily: {
        display: ['Inter', 'system-ui', 'sans-serif'],
        body: ['Inter', 'system-ui', 'sans-serif'],
      },
      borderRadius: {
        '3xl': '24px',
        '4xl': '32px',
        '5xl': '40px',
      },
      boxShadow: {
        'premium': '0 10px 40px rgba(0,0,0,0.12)',
        'premium-lg': '0 20px 60px rgba(0,0,0,0.15)',
        'cinematic': '0 25px 50px -12px rgba(0, 0, 0, 0.25)',
      },
      backdropBlur: {
        'xs': '2px',
      },
    },
  },
  plugins: [],
}
