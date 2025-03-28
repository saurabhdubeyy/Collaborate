#!/bin/bash
# Script to push updated code to GitHub repository

# Configure Git if needed
# git config --global user.name "Your Name"
# git config --global user.email "your.email@example.com"

echo "Checking Git status..."
git status

echo "Adding all changes to Git..."
git add .

echo "Committing changes..."
$commitMessage = "Improved project structure and deployment configuration"
git commit -m $commitMessage

echo "Pushing to GitHub..."
git push origin main

echo "Done! Changes have been pushed to GitHub." 