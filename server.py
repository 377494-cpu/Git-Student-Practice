import http.server
import socketserver
import socket

PORT = 5000
HOST = "0.0.0.0"

class NoCacheHandler(http.server.SimpleHTTPRequestHandler):
    def end_headers(self):
        self.send_header('Cache-Control', 'no-cache, no-store, must-revalidate')
        self.send_header('Pragma', 'no-cache')
        self.send_header('Expires', '0')
        super().end_headers()

class ReuseAddrTCPServer(socketserver.TCPServer):
    allow_reuse_address = True
    
    def server_bind(self):
        self.socket.setsockopt(socket.SOL_SOCKET, socket.SO_REUSEADDR, 1)
        super().server_bind()

with ReuseAddrTCPServer((HOST, PORT), NoCacheHandler) as httpd:
    print(f"Serving at http://{HOST}:{PORT}")
    httpd.serve_forever()
