# Servidor HTTP estático simples — para preview local da home Nuvvo
# Uso: powershell -ExecutionPolicy Bypass -File serve.ps1
# Depois abrir: http://localhost:8080

$port = 8080
$root = $PSScriptRoot

$mime = @{
  ".html" = "text/html; charset=utf-8"
  ".htm"  = "text/html; charset=utf-8"
  ".css"  = "text/css; charset=utf-8"
  ".js"   = "application/javascript; charset=utf-8"
  ".json" = "application/json; charset=utf-8"
  ".svg"  = "image/svg+xml"
  ".png"  = "image/png"
  ".jpg"  = "image/jpeg"
  ".jpeg" = "image/jpeg"
  ".webp" = "image/webp"
  ".gif"  = "image/gif"
  ".ico"  = "image/x-icon"
  ".mp4"  = "video/mp4"
  ".webm" = "video/webm"
  ".woff" = "font/woff"
  ".woff2"= "font/woff2"
  ".pdf"  = "application/pdf"
  ".txt"  = "text/plain; charset=utf-8"
}

$listener = New-Object System.Net.HttpListener
$listener.Prefixes.Add("http://localhost:$port/")
$listener.Start()
Write-Host "`n  Nuvvo Design Home" -ForegroundColor Cyan
Write-Host "  Rodando em: http://localhost:$port" -ForegroundColor Green
Write-Host "  Pasta:      $root"
Write-Host "  Ctrl+C para parar`n" -ForegroundColor DarkGray

try {
  while ($listener.IsListening) {
    $ctx = $listener.GetContext()
    $req = $ctx.Request
    $res = $ctx.Response

    $path = [uri]::UnescapeDataString($req.Url.AbsolutePath)
    if ($path -eq "/") { $path = "/index.html" }
    $file = Join-Path $root $path.TrimStart("/").Replace("/", [IO.Path]::DirectorySeparatorChar)

    if (Test-Path -LiteralPath $file -PathType Leaf) {
      $ext = [IO.Path]::GetExtension($file).ToLower()
      $ct  = if ($mime.ContainsKey($ext)) { $mime[$ext] } else { "application/octet-stream" }
      try {
        $bytes = [IO.File]::ReadAllBytes($file)
        $res.ContentType = $ct
        $res.ContentLength64 = $bytes.Length
        $res.StatusCode = 200
        $res.OutputStream.Write($bytes, 0, $bytes.Length)
        Write-Host "  200  $path" -ForegroundColor DarkGreen
      } catch {
        $res.StatusCode = 500
        Write-Host "  500  $path  $($_.Exception.Message)" -ForegroundColor Red
      }
    } else {
      $res.StatusCode = 404
      $msg = [Text.Encoding]::UTF8.GetBytes("404 Not Found: $path")
      $res.OutputStream.Write($msg, 0, $msg.Length)
      Write-Host "  404  $path" -ForegroundColor Yellow
    }
    $res.Close()
  }
} finally {
  $listener.Stop()
  $listener.Close()
}
