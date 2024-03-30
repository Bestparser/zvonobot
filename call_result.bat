@echo off

net use N: \\85.143.100.14\SdoMonitoring
xcopy "C:\SdoMonitoring\call_results_1.csv" "N:\" /D /Y
net use N: /delete /y