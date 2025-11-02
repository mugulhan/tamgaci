# Tamgaci Theme Release Guide

Bu dokümanda Tamgaci teması için release (sürüm yayınlama) işleminin nasıl yapılacağı anlatılmaktadır.

## Otomatik Release (Önerilen)

`release.sh` scripti ile tüm release işlemi otomatik olarak yapılır.

### Kullanım

Tema dizininde şu komutu çalıştırın:

```bash
./release.sh
```

Script sizden şunları soracaktır:

1. **Versiyon artırma türü:**
   - `1` - Patch (0.10.3 → 0.10.4) - Küçük düzeltmeler için
   - `2` - Minor (0.10.3 → 0.11.0) - Yeni özellikler için
   - `3` - Major (0.10.3 → 1.0.0) - Büyük değişiklikler için
   - `4` - Custom - Manuel versiyon girişi

2. **Commit mesajı:** (opsiyonel)
   - Boş bırakırsanız: "Bump version to X.X.X" kullanılır
   - Değişiklikleri açıklayan bir mesaj yazabilirsiniz

3. **Onay:** Release işlemini başlatmak için `y` yazın

### Script Ne Yapar?

1. ✅ `style.css` dosyasındaki versiyonu günceller
2. ✅ `functions.php` dosyasındaki `TAMGACI_VERSION` sabitini günceller
3. ✅ Git commit oluşturur
4. ✅ Git tag oluşturur (örn: v0.10.4)
5. ✅ Deployment ZIP paketi oluşturur
6. ✅ GitHub'a push eder (commit + tag)
7. ✅ GitHub Release oluşturur ve ZIP'i yükler
8. ✅ Geçici ZIP dosyasını temizler

### Örnek Kullanım

```bash
cd /Users/muhammetgulhan/Documents/tamgaci-dev/wordpress/wp-content/themes/tamgaci
./release.sh
```

Çıktı:
```
[INFO] Tamgaci Theme Release Script

[INFO] Current version: 0.10.3

Select version increment type:
  1) Patch (0.10.3 -> 0.10.4)
  2) Minor (0.10.3 -> 0.11.0)
  3) Major (0.10.3 -> 1.0.0)
  4) Custom version

Enter choice [1-4]: 1
[INFO] New version will be: 0.10.4

Enter commit message (optional): Fix mobile menu alignment issues

[WARNING] This will:
  1. Update version in style.css and functions.php
  2. Create a git commit
  3. Create a git tag (v0.10.4)
  4. Create a deployment ZIP package
  5. Push to GitHub
  6. Create a GitHub Release

Continue? [y/N] y

[INFO] Starting release process...
...
[SUCCESS] Release v0.10.4 completed successfully!

[INFO] Release URL: https://github.com/mugulhan/tamgaci/releases/tag/v0.10.4
```

## Manuel Release (Eski Yöntem)

Eğer script kullanmak istemezseniz, manual olarak şu adımları takip edebilirsiniz:

### 1. Versiyon Güncelleme

`style.css` dosyasını düzenleyin:
```css
Version: 0.10.4
```

`functions.php` dosyasını düzenleyin:
```php
define( 'TAMGACI_VERSION', '0.10.4' );
```

### 2. Git Commit ve Tag

```bash
git add style.css functions.php
git commit -m "Bump version to 0.10.4"
git tag v0.10.4
```

### 3. ZIP Paketi Oluşturma

```bash
zip -r tamgaci-v0.10.4.zip . \
    -x "*.git*" \
    -x "*node_modules*" \
    -x "*.DS_Store" \
    -x "*src/*" \
    -x "*release.sh" \
    -x "*.zip" \
    -x "*package.json" \
    -x "*package-lock.json" \
    -x "*tailwind.config.js" \
    -x "*postcss.config.js"
```

### 4. GitHub'a Push

```bash
git push origin main
git push origin v0.10.4
```

### 5. GitHub Release

```bash
gh release create v0.10.4 tamgaci-v0.10.4.zip \
    --title "v0.10.4" \
    --notes "Release notes here..."
```

## Versiyon Numaralandırma

Semantic Versioning (SemVer) kullanıyoruz: `MAJOR.MINOR.PATCH`

- **MAJOR (1.0.0):** API değişiklikleri, uyumsuz değişiklikler
- **MINOR (0.1.0):** Yeni özellikler, geriye dönük uyumlu
- **PATCH (0.0.1):** Bug düzeltmeleri, küçük iyileştirmeler

### Örnekler:

- Mobil menü hatası düzeltildi → **Patch** (0.10.3 → 0.10.4)
- Yeni karşılaştırma özelliği eklendi → **Minor** (0.10.3 → 0.11.0)
- Tüm tema mimarisi değişti → **Major** (0.10.3 → 1.0.0)

## Gereksinimler

- Git yüklü olmalı
- GitHub CLI (`gh`) yüklü olmalı
- GitHub'a kimlik doğrulaması yapılmış olmalı (`gh auth login`)
- Tema dizininde git repository olmalı

## Sorun Giderme

### "Not a git repository" hatası
```bash
cd /Users/muhammetgulhan/Documents/tamgaci-dev/wordpress/wp-content/themes/tamgaci
```

### GitHub CLI yüklü değil
```bash
brew install gh
gh auth login
```

### Script çalıştırma izni yok
```bash
chmod +x release.sh
```

## Notlar

- Script, ZIP paketini oluşturduktan ve GitHub Release'e yükledikten sonra otomatik olarak siler
- Tüm release'ler https://github.com/mugulhan/tamgaci/releases adresinde görüntülenebilir
- WordPress yönetim panelinden "Appearance > Themes" bölümünden otomatik güncelleme yapılabilir
