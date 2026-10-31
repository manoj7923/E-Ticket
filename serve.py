#!/usr/bin/env python3
"""
Mumbai Suburban Railway E-Ticket Local Preview Server
Western, Central & Harbour Lines • Interactive Transit Map & 12h Validity
Launches a lightweight local server and opens your browser automatically.
"""

import http.server
import socketserver
import webbrowser
import os
import sys

PORT = 8080
DIRECTORY = os.path.dirname(os.path.abspath(__file__))

class Handler(http.server.SimpleHTTPRequestHandler):
    def __init__(self, *args, **kwargs):
        super().__init__(*args, directory=DIRECTORY, **kwargs)

    def do_GET(self):
        # Default root requests to demo.html if accessing directly via static preview
        if self.path == '/' or self.path == '/index.html':
            self.path = '/demo.html'
        return super().do_GET()

def run():
    os.chdir(DIRECTORY)
    print("=" * 70)
    print("  MUMBAI SUBURBAN RAILWAY E-TICKET PORTAL - LOCAL PREVIEW SERVER")
    print("  Western, Central & Harbour Lines • Interactive Map • 12h Validity")
    print("=" * 70)
    print(f"  * Serving Directory: {DIRECTORY}")
    print(f"  * Local Web URL:     http://localhost:{PORT}")
    print(f"  * Interactive Demo:  http://localhost:{PORT}/demo.html")
    print("=" * 70)
    print("  Opening your browser now... (Press Ctrl+C to stop)")
    print("=" * 70)

    try:
        webbrowser.open(f"http://localhost:{PORT}/demo.html")
    except Exception:
        pass

    with socketserver.TCPServer(("", PORT), Handler) as httpd:
        try:
            httpd.serve_forever()
        except KeyboardInterrupt:
            print("\nServer stopped.")

if __name__ == '__main__':
    run()