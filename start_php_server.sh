#!/bin/bash

PORT=8088
DIRECTORY="/home/dila/gteep/repo/dev/archive-management"
COMMAND="php artisan serve --port=$PORT"

# Check if the port is in use
if sudo lsof -i:$PORT -P -n | grep LISTEN; then
    echo "Port $PORT is already in use. Exiting gracefully."
    exit 0
else
    # Navigate to the target directory
    cd "$DIRECTORY" || { echo "Directory $DIRECTORY not found. Exiting."; exit 1; }

    # Start the PHP server
    echo "Starting PHP server on port $PORT..."
    $COMMAND &

    # Check if the port is now listening
    if sudo lsof -i:$PORT -P -n | grep LISTEN; then
        echo "PHP server started successfully on port $PORT."
    else
        echo "Failed to start the PHP server. Checking service status..."
        sudo systemctl restart start-php-server.service
    fi
fi
