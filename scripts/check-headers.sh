#!/bin/bash

/**
 * Project: Gatita Bakes Online Order System
 * Title: Header Check Script
 * Author/Developer: Bucketbranch Engineering LLC
 * Version: 20250905.1
 * Date: 2025-09-05
 */

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Current date in YYYY-MM-DD format
CURRENT_DATE=$(date +%Y-%m-%d)

# Function to check if a file should be excluded
should_exclude() {
    local file="$1"
    # Exclude certain directories and file types
    if [[ "$file" == *"node_modules"* ]] || 
       [[ "$file" == *".git"* ]] || 
       [[ "$file" == *".DS_Store"* ]] ||
       [[ "$file" == *".jpg" ]] ||
       [[ "$file" == *".png" ]] ||
       [[ "$file" == *".pdf" ]] ||
       [[ "$file" == *".lock" ]]; then
        return 0 # true, should exclude
    fi
    return 1 # false, should not exclude
}

# Function to get file title from filename
get_file_title() {
    local filename=$(basename "$1")
    local extension="${filename##*.}"
    local name="${filename%.*}"
    # Convert hyphens and underscores to spaces and capitalize words
    echo "$name" | sed 's/[-_]/ /g' | awk '{for(i=1;i<=NF;i++)sub(/./,toupper(substr($i,1,1)),$i)}1'
}

# Function to fix file header
fix_header() {
    local file="$1"
    local title=$(get_file_title "$file")
    local temp_file=$(mktemp)
    
    # Create new header
    cat > "$temp_file" << EOF
/**
 * Project: Gatita Bakes Online Order System
 * Title: $title
 * Author/Developer: Bucketbranch Engineering LLC
 * Version: 20250905.1
 * Date: $CURRENT_DATE
 */

EOF

    # Append existing file content, skipping old header if it exists
    if grep -q "/\*\*" "$file"; then
        sed '1,/\*\//d' "$file" >> "$temp_file"
    else
        cat "$file" >> "$temp_file"
    fi

    # Replace original file with new version
    mv "$temp_file" "$file"
    echo -e "${GREEN}Fixed header in $file${NC}"
}

echo "Checking file headers against project rules..."
echo "============================================"

# Initialize counters
total_files=0
files_with_issues=0
fixed_files=0

# Find all files recursively, excluding certain patterns
while IFS= read -r -d '' file; do
    # Skip excluded files
    if should_exclude "$file"; then
        continue
    fi

    ((total_files++))
    has_issues=0
    echo -e "\nChecking ${YELLOW}$file${NC}..."
    
    # Check for required header elements
    if ! grep -q "Project: Gatita Bakes Online Order System" "$file"; then
        echo -e "${RED}Missing or incorrect project name${NC}"
        has_issues=1
    fi
    
    if ! grep -q "Author/Developer: Bucketbranch Engineering LLC" "$file"; then
        echo -e "${RED}Missing or incorrect author${NC}"
        has_issues=1
    fi
    
    if ! grep -q "Version: 20250905.1" "$file"; then
        echo -e "${RED}Missing or incorrect version${NC}"
        has_issues=1
    fi
    
    # Check date format (YYYY-MM-DD)
    if ! grep -q "Date: [0-9]\{4\}-[0-9]\{2\}-[0-9]\{2\}" "$file"; then
        echo -e "${RED}Missing or incorrect date format${NC}"
        has_issues=1
    fi

    if [ $has_issues -eq 1 ]; then
        ((files_with_issues++))
        echo -e "Would you like to fix this file? (y/n)"
        read -n 1 -r
        echo
        if [[ $REPLY =~ ^[Yy]$ ]]; then
            fix_header "$file"
            ((fixed_files++))
        fi
    else
        echo -e "${GREEN}✓ Header is compliant${NC}"
    fi
done < <(find . -type f -not -path "*/\.*" -print0)

echo -e "\n============================================"
echo -e "Scan Complete!"
echo -e "Total files scanned: ${YELLOW}$total_files${NC}"
echo -e "Files with issues: ${RED}$files_with_issues${NC}"
echo -e "Files fixed: ${GREEN}$fixed_files${NC}"
echo -e "============================================" 