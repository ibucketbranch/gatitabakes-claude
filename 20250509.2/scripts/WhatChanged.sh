#!/bin/bash

# directory to “touch”
dir="/Users/michaelvalderrama/Websites/Claude"

# find the newest file in that directory (recursively)
newest=$(find "$dir" -type f -print0 \
         | xargs -0 stat -f "%m %N" \
         | sort -nr \
         | head -n1 \
         | cut -d' ' -f2-)

# update the directory’s mod-time to match that file
touch -r "$newest" "$dir"
