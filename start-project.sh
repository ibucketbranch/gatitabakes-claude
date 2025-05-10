#!/bin/bash
# 
# Project: Gatita Bakes Online Order System
# Title: Start Project Script
# Author/Developer: Bucketbranch Engineering LLC
# Version: 20250905.1
# Date: 2025-05-10
#

# Make the script executable
chmod +x "$0"

# Get the script's directory
SCRIPT_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
cd "$SCRIPT_DIR"

# Check for running Python servers and kill them
echo "Checking for running servers..."
pkill -f "python3 -m http.server"
echo "Server processes stopped."

# Determine the current branch
CURRENT_BRANCH=$(git branch | grep '*' | sed 's/* //')
echo "Current Git branch: $CURRENT_BRANCH"

# Find the most recent project folder in YYYYMMDD.x format
LATEST_FOLDER=$(ls -d 2*/ 2>/dev/null | sort -r | head -n 1)
if [ -z "$LATEST_FOLDER" ]; then
    echo "No date-based folders found. Using main project directory."
    PROJECT_DIR="$SCRIPT_DIR/public_html"
else
    echo "Latest project folder: $LATEST_FOLDER"
    # Remove trailing slash
    LATEST_FOLDER=${LATEST_FOLDER%/}
    if [ -d "$SCRIPT_DIR/$LATEST_FOLDER/public_html" ]; then
        PROJECT_DIR="$SCRIPT_DIR/$LATEST_FOLDER/public_html"
    else
        echo "No public_html in latest folder. Using main public_html."
        PROJECT_DIR="$SCRIPT_DIR/public_html"
    fi
fi

echo "Starting server from: $PROJECT_DIR"
cd "$PROJECT_DIR"

# Start the server in the background
python3 -m http.server 8002 &
SERVER_PID=$!

echo "Server started with PID: $SERVER_PID"
echo "You can access the site at: http://localhost:8002/"
echo "To visit the cache clearer: http://localhost:8002/clear-cache.php"
echo "To stop the server, run: kill $SERVER_PID"

# Open VS Code workspace if it exists
if [ -f "$SCRIPT_DIR/gatitabakes.code-workspace" ]; then
    echo "Opening VS Code workspace..."
    code "$SCRIPT_DIR/gatitabakes.code-workspace"
fi

# Print helpful navigation commands
echo ""
echo "=== Quick Navigation Commands ==="
echo "cd $PROJECT_DIR"
echo "code $SCRIPT_DIR/gatitabakes.code-workspace"
echo "open http://localhost:8002/clear-cache.php"
echo "" 