/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/views/**/*.blade.php",
    "./resources/js/**/*.js",
  ],
  theme: {
    extend: {
      colors: {
        coffee: {
          50: '#faf7f2',
          100: '#f5ede5',
          200: '#ebd7cb',
          300: '#d9b8a3',
          400: '#c9956b',
          500: '#a67b5b',
          600: '#8a6344',
          700: '#6f4e37',
          800: '#5c3f2f',
          900: '#3d2817',
          950: '#2c1f14',
        },
        accent: {
          50: '#fffbf0',
          100: '#fef3e0',
          200: '#fde7c0',
          300: '#fcd5a0',
          400: '#fac180',
          500: '#f8ad60',
          600: '#f39c12',
          700: '#c07c0c',
          800: '#8a5707',
          900: '#5c3b04',
        },
      },
      fontFamily: {
        poppins: ['Poppins', 'sans-serif'],
        serif: ['Playfair Display', 'serif'],
      },
      borderRadius: {
        xl: '1rem',
        '2xl': '1.5rem',
        '3xl': '2rem',
      },
      boxShadow: {
        'card': '0 4px 15px rgba(0, 0, 0, 0.08)',
        'hover': '0 12px 24px rgba(0, 0, 0, 0.12)',
        'glass': '0 8px 32px rgba(0, 0, 0, 0.1)',
      },
      animation: {
        'fade-in': 'fadeIn 0.5s ease-in',
        'slide-up': 'slideUp 0.5s ease-out',
        'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
      },
      keyframes: {
        fadeIn: {
          '0%': { opacity: '0' },
          '100%': { opacity: '1' },
        },
        slideUp: {
          '0%': { transform: 'translateY(10px)', opacity: '0' },
          '100%': { transform: 'translateY(0)', opacity: '1' },
        },
      },
      spacing: {
        'safe-bottom': 'env(safe-area-inset-bottom)',
      },
    },
  },
  plugins: [],
}
