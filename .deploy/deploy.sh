#!/usr/bin/env bash
#
# Deploy do site para o servidor FTP (/public_html) via curl.
# Credenciais lidas de sftp/sftp.json (fora do git).
#
# Uso:
#   .deploy/deploy.sh --all              # envia TODOS os arquivos versionados
#   .deploy/deploy.sh <old_sha> <new_sha># envia só o que mudou entre 2 commits
#   .deploy/deploy.sh --dry-run --all    # simula, sem enviar nada
#
# Arquivos de infraestrutura (dotfiles, sftp/) nunca são enviados ao servidor.

set -u

REPO_ROOT="$(git rev-parse --show-toplevel)"
cd "$REPO_ROOT" || exit 1

CONFIG="sftp/sftp.json"
if [ ! -f "$CONFIG" ]; then
  echo "ERRO: $CONFIG não encontrado (credenciais)." >&2
  exit 1
fi

# --- lê config JSON (sem dependências externas) ---
jstr() { sed -n "s/.*\"$1\"[[:space:]]*:[[:space:]]*\"\([^\"]*\)\".*/\1/p" "$CONFIG" | head -1; }
jnum() { sed -n "s/.*\"$1\"[[:space:]]*:[[:space:]]*\([0-9]\+\).*/\1/p" "$CONFIG" | head -1; }

HOST="$(jstr host)"
PORT="$(jnum port)"; [ -z "$PORT" ] && PORT=21
USER_="$(jstr username)"
PASS="$(jstr password)"
REMOTE="$(jstr remotePath)"; REMOTE="${REMOTE#/}"   # remove barra inicial
[ -z "$REMOTE" ] && REMOTE="public_html"

if [ -z "$HOST" ] || [ -z "$USER_" ] || [ -z "$PASS" ]; then
  echo "ERRO: host/username/password ausentes em $CONFIG." >&2
  exit 1
fi

DRY=0
ARGS=()
for a in "$@"; do
  if [ "$a" = "--dry-run" ]; then DRY=1; else ARGS+=("$a"); fi
done
set -- "${ARGS[@]:-}"

# ignora arquivos de infraestrutura (dotfiles na raiz e pasta sftp/)
is_excluded() {
  case "$1" in
    .*|sftp/*) return 0 ;;
    *) return 1 ;;
  esac
}

FTP_BASE="ftp://$HOST:$PORT"
OK=0; FAIL=0; DEL=0; SKIP=0

upload() {
  local f="$1"
  if is_excluded "$f"; then SKIP=$((SKIP+1)); return; fi
  if [ ! -f "$f" ]; then
    echo "  ~ ignorado (não existe no disco): $f"; SKIP=$((SKIP+1)); return
  fi
  if [ "$DRY" = "1" ]; then echo "  [dry] UP  $f"; OK=$((OK+1)); return; fi
  if curl -s --connect-timeout 20 --ftp-create-dirs -T "$f" \
        --user "$USER_:$PASS" "$FTP_BASE/$REMOTE/$f"; then
    echo "  ✔ UP  $f"; OK=$((OK+1))
  else
    echo "  x FALHA UP  $f" >&2; FAIL=$((FAIL+1))
  fi
}

remove() {
  local f="$1"
  if is_excluded "$f"; then SKIP=$((SKIP+1)); return; fi
  if [ "$DRY" = "1" ]; then echo "  [dry] DEL $f"; DEL=$((DEL+1)); return; fi
  if curl -s --connect-timeout 20 --user "$USER_:$PASS" \
        -Q "DELE $REMOTE/$f" "$FTP_BASE/" >/dev/null 2>&1; then
    echo "  ✔ DEL $f"; DEL=$((DEL+1))
  else
    echo "  ~ DEL falhou/ignorado (talvez já não exista): $f" >&2
  fi
}

MODE="${1:---all}"

if [ "$MODE" = "--all" ]; then
  echo "== Deploy COMPLETO -> $HOST/$REMOTE =="
  while IFS= read -r f; do
    [ -z "$f" ] && continue
    upload "$f"
  done < <(git ls-files)
else
  OLD="$1"; NEW="${2:-HEAD}"
  echo "== Deploy INCREMENTAL ($OLD -> $NEW) -> $HOST/$REMOTE =="
  # status: A/M/D/R... com detecção de rename
  while IFS=$'\t' read -r status a b; do
    case "$status" in
      D)   remove "$a" ;;
      R*)  remove "$a"; upload "$b" ;;   # renomeado: apaga antigo, envia novo
      C*)  upload "$b" ;;                # copiado
      *)   upload "$a" ;;               # A, M, T
    esac
  done < <(git diff --name-status -M "$OLD" "$NEW")
fi

echo "== Resumo: $OK enviados, $DEL removidos, $SKIP ignorados, $FAIL falhas =="
# não falha o push por causa de deploy (GitHub continua sendo backup confiável)
exit 0
