#!/bin/bash

# Tamgaci Theme Release Script
# This script automates the process of creating a new theme release

set -e  # Exit on error

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Configuration
THEME_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
THEME_NAME="tamgaci"
STYLE_CSS="$THEME_DIR/style.css"
FUNCTIONS_PHP="$THEME_DIR/functions.php"

# Function to print colored messages
print_info() {
    echo -e "${BLUE}[INFO]${NC} $1"
}

print_success() {
    echo -e "${GREEN}[SUCCESS]${NC} $1"
}

print_warning() {
    echo -e "${YELLOW}[WARNING]${NC} $1"
}

print_error() {
    echo -e "${RED}[ERROR]${NC} $1"
}

# Function to get current version
get_current_version() {
    grep "^Version:" "$STYLE_CSS" | awk '{print $2}' | tr -d '\r'
}

# Function to increment version
increment_version() {
    local version=$1
    local type=$2

    IFS='.' read -r -a parts <<< "$version"
    major="${parts[0]}"
    minor="${parts[1]}"
    patch="${parts[2]}"

    case $type in
        major)
            major=$((major + 1))
            minor=0
            patch=0
            ;;
        minor)
            minor=$((minor + 1))
            patch=0
            ;;
        patch)
            patch=$((patch + 1))
            ;;
        *)
            print_error "Invalid version type: $type"
            exit 1
            ;;
    esac

    echo "$major.$minor.$patch"
}

# Main script
print_info "Tamgaci Theme Release Script"
echo ""

# Check if we're in a git repository
if [ ! -d ".git" ]; then
    print_error "Not a git repository!"
    exit 1
fi

# Get current version
CURRENT_VERSION=$(get_current_version)
print_info "Current version: $CURRENT_VERSION"

# Ask for version increment type
echo ""
echo "Select version increment type:"
echo "  1) Patch (${CURRENT_VERSION} -> $(increment_version $CURRENT_VERSION patch))"
echo "  2) Minor (${CURRENT_VERSION} -> $(increment_version $CURRENT_VERSION minor))"
echo "  3) Major (${CURRENT_VERSION} -> $(increment_version $CURRENT_VERSION major))"
echo "  4) Custom version"
echo ""
read -p "Enter choice [1-4]: " choice

case $choice in
    1)
        NEW_VERSION=$(increment_version $CURRENT_VERSION patch)
        ;;
    2)
        NEW_VERSION=$(increment_version $CURRENT_VERSION minor)
        ;;
    3)
        NEW_VERSION=$(increment_version $CURRENT_VERSION major)
        ;;
    4)
        read -p "Enter new version: " NEW_VERSION
        ;;
    *)
        print_error "Invalid choice!"
        exit 1
        ;;
esac

print_info "New version will be: $NEW_VERSION"
echo ""

# Ask for commit message
read -p "Enter commit message (optional): " COMMIT_MESSAGE
if [ -z "$COMMIT_MESSAGE" ]; then
    COMMIT_MESSAGE="Bump version to $NEW_VERSION"
fi

echo ""
print_warning "This will:"
echo "  1. Update version in style.css and functions.php"
echo "  2. Create a git commit"
echo "  3. Create a git tag (v$NEW_VERSION)"
echo "  4. Create a deployment ZIP package"
echo "  5. Push to GitHub"
echo "  6. Create a GitHub Release"
echo ""
read -p "Continue? [y/N] " confirm

if [[ ! "$confirm" =~ ^[Yy]$ ]]; then
    print_info "Cancelled."
    exit 0
fi

echo ""
print_info "Starting release process..."
echo ""

# Step 1: Update version in style.css
print_info "Updating version in style.css..."
sed -i.bak "s/^Version: .*/Version: $NEW_VERSION/" "$STYLE_CSS"
rm -f "${STYLE_CSS}.bak"
print_success "Updated style.css"

# Step 2: Update version in functions.php
print_info "Updating version in functions.php..."
sed -i.bak "s/define( 'TAMGACI_VERSION', '[^']*' );/define( 'TAMGACI_VERSION', '$NEW_VERSION' );/" "$FUNCTIONS_PHP"
rm -f "${FUNCTIONS_PHP}.bak"
print_success "Updated functions.php"

# Step 3: Create git commit
print_info "Creating git commit..."
git add "$STYLE_CSS" "$FUNCTIONS_PHP"
git commit -m "$(cat <<EOF
$COMMIT_MESSAGE

🤖 Generated with [Claude Code](https://claude.com/claude-code)

Co-Authored-By: Claude <noreply@anthropic.com>
EOF
)"
print_success "Created git commit"

# Step 4: Create git tag
print_info "Creating git tag v$NEW_VERSION..."
git tag "v$NEW_VERSION"
print_success "Created git tag"

# Step 5: Create deployment ZIP
print_info "Creating deployment ZIP..."
ZIP_NAME="${THEME_NAME}-v${NEW_VERSION}.zip"
ZIP_PATH="$THEME_DIR/$ZIP_NAME"
TEMP_DIR=$(mktemp -d)
TEMP_THEME_DIR="$TEMP_DIR/$THEME_NAME"

# Remove old ZIP if exists
rm -f "$ZIP_PATH"

# Create temporary directory with theme name
mkdir -p "$TEMP_THEME_DIR"

# Copy theme files to temp directory excluding unnecessary files
rsync -a "$THEME_DIR/" "$TEMP_THEME_DIR/" \
    --exclude='.git' \
    --exclude='.gitignore' \
    --exclude='node_modules' \
    --exclude='.DS_Store' \
    --exclude='src' \
    --exclude='release.sh' \
    --exclude='*.zip' \
    --exclude='package.json' \
    --exclude='package-lock.json' \
    --exclude='tailwind.config.js' \
    --exclude='postcss.config.js'

# Create ZIP from parent directory so it includes the theme folder
cd "$TEMP_DIR"
zip -r "$ZIP_PATH" "$THEME_NAME" > /dev/null 2>&1

# Clean up temp directory
rm -rf "$TEMP_DIR"

print_success "Created deployment ZIP: $ZIP_NAME"

# Step 6: Push to GitHub
print_info "Pushing to GitHub..."
git push origin main
git push origin "v$NEW_VERSION"
print_success "Pushed to GitHub"

# Step 7: Create GitHub Release
print_info "Creating GitHub Release..."
gh release create "v$NEW_VERSION" "$ZIP_PATH" \
    --title "v$NEW_VERSION" \
    --notes "$(cat <<EOF
## Release v$NEW_VERSION

$COMMIT_MESSAGE

### Installation
Download the \`$ZIP_NAME\` file and install it through WordPress admin panel.

---

🤖 Generated with [Claude Code](https://claude.com/claude-code)
EOF
)"
print_success "Created GitHub Release"

# Cleanup
print_info "Cleaning up..."
rm -f "$ZIP_PATH"
print_success "Removed local ZIP file"

echo ""
print_success "Release v$NEW_VERSION completed successfully!"
echo ""
print_info "Release URL: https://github.com/mugulhan/tamgaci/releases/tag/v$NEW_VERSION"
echo ""
