const path = require('path');
const fs = require('fs');
const webpack = require('webpack'); // 🔹 Tambahkan ini agar Webpack dikenali


// Fungsi untuk mencari semua script.js di dalam folder Pages/
function getAllScripts() {
  const baseDir = path.resolve(__dirname, '../../app');
  const scripts = [];

  function readDirRecursive(directory) {
    fs.readdirSync(directory).forEach(file => {
      const fullPath = path.join(directory, file);
      if (fs.statSync(fullPath).isDirectory()) {
        readDirRecursive(fullPath);
      } else if (file === 'script.js') {
        scripts.push(fullPath);
      }
    });
  }

  readDirRecursive(baseDir);
  return scripts;
}

module.exports = {
  mode: 'development',
  entry: {
    'heroic': './heroic.js', // Tanpa dependensi seperti Axios
    'pagescript': getAllScripts()
  },
  output: {
    filename: '[name].dev.js', // Development tetap pakai nama normal
    path: path.resolve(__dirname, 'assets/js'),
  },
  module: {
    rules: [
      {
        test: /\.js$/,
        exclude: /node_modules/,
        use: {
          loader: 'babel-loader',
          options: {
            presets: ['@babel/preset-env'],
          },
        },
      },
    ],
  },
  devtool: 'eval-source-map', // Source map lebih cepat untuk debugging
  watch: true, // Auto-recompile saat ada perubahan
};
