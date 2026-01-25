#!/bin/bash

# chathist.sh - A script to display chat history from a TOML file.

# Check if yq is installed or available in the current directory
if ! command -v yq &> /dev/null && [ ! -x "./yq" ]; then
    echo "yq could not be found. Please install yq or place it in the current directory."
    exit 1
fi

# Determine which yq executable to use
YQ_COMMAND="yq"
if [ -x "./yq" ]; then
    YQ_COMMAND="./yq"
fi

# Path to the chat history file
HISTORY_FILE=".gemini/chathist.toml"

# Check if the history file exists
if [ ! -f "$HISTORY_FILE" ]; then
    echo "Chat history file not found: $HISTORY_FILE"
    exit 1
fi

# Use yq to parse the TOML file and display the chat history
$YQ_COMMAND -r '.history[] | .role + ": " + .content' "$HISTORY_FILE"
