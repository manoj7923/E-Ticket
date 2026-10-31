@echo off
title Western Railway E-Ticket Portal
echo ========================================================
echo  Launching Western Railway E-Ticket Portal Preview
echo ========================================================
cd /d "%~dp0"
python serve.py
pause
