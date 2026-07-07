# Deploy do site Nuvvo

O site é versionado no Git (GitHub) e publicado no servidor via **FTP**.
Como o servidor (`10.10.10.1`) só é acessível pela **VPN**, o deploy sai
sempre do seu PC — disparado automaticamente a cada `git push`.

```
edita  ->  git commit  ->  git push  ->  GitHub (backup + histórico)
                                           |
                                           v  (hook pre-push, no seu PC)
                                     .deploy/deploy.sh  ->  FTP /public_html
```

## Uso normal

Basta o fluxo git de sempre:

```bash
git add .
git commit -m "minha alteração"
git push
```

No `push` da branch `main`, os arquivos **alterados naquele push** sobem
para o servidor. Arquivos removidos no git são apagados no servidor.

> Você precisa estar conectado na **VPN** na hora do push. Se não estiver,
> o push para o GitHub funciona mesmo assim e aparece um aviso — depois é só
> rodar um deploy manual (abaixo) já conectado.

## Deploy manual

```bash
# Reenviar TODOS os arquivos versionados (re-sincronização completa)
bash .deploy/deploy.sh --all

# Enviar só o que mudou entre dois commits
bash .deploy/deploy.sh <sha_antigo> <sha_novo>

# Simular sem enviar nada (ver o que aconteceria)
bash .deploy/deploy.sh --dry-run --all
```

## Detalhes

- **Credenciais**: lidas de `sftp/sftp.json` (fora do Git, no `.gitignore`).
- **Nunca são enviados** ao servidor: arquivos de infraestrutura (dotfiles
  como `.deploy/`, `.githooks/`, `.gitignore`) e a pasta `sftp/`.
- **Hook**: `.githooks/pre-push`, ativado por `git config core.hooksPath .githooks`.
  Se clonar o repositório em outra máquina, rode uma vez:
  ```bash
  git config core.hooksPath .githooks
  ```
- O deploy **não bloqueia** o push: falhas de rede/VPN só geram aviso, o
  GitHub continua como backup confiável.
