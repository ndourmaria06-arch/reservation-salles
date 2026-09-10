#!/usr/bin/env bash
set -e

DOCKERHUB_USER="mariama2000"
IMAGE_NAME="reservation-salles"

docker login

# On copie le Dockerfile actuel dans un dossier temporaire, pour l'injecter dans les vieux tags
cp Dockerfile /tmp/Dockerfile.current
cp public/.htaccess /tmp/htaccess.current 2>/dev/null || true

TAGS="v0.1.0 v0.2.0 v0.3.0 v0.4.0 v0.5.0 v0.6.0 v0.7.0 v0.8.0 v0.9.0"

for TAG in $TAGS; do
    echo "=== Traitement de $TAG ==="
    WORKTREE_DIR="/tmp/build-$TAG"
    rm -rf "$WORKTREE_DIR"
    git worktree add --detach "$WORKTREE_DIR" "$TAG"

    cp /tmp/Dockerfile.current "$WORKTREE_DIR/Dockerfile"
    mkdir -p "$WORKTREE_DIR/public"
    cp /tmp/htaccess.current "$WORKTREE_DIR/public/.htaccess" 2>/dev/null || true

    if docker build -t "$DOCKERHUB_USER/$IMAGE_NAME:$TAG" "$WORKTREE_DIR"; then
        docker push "$DOCKERHUB_USER/$IMAGE_NAME:$TAG"
        echo "✅ $TAG construit et poussé"
    else
        echo "❌ $TAG a échoué à la construction"
    fi

    git worktree remove "$WORKTREE_DIR" --force
done

echo "Terminé."