if($args[0] -eq "uninstall") {
    Start-Process "msiexec.exe" -ArgumentList "/x {61D44ABF-A11F-4FA4-98E6-C05BBBD0B52A}" -NoNewWindow -Wait
}else{
    $dfu = "C:\Program Files (x86)\STMicroelectronics\Software\DfuSe v$($args[0])"
    if (-Not (Test-Path $dfu)){
		$dfu_install = "$env:userprofile\Downloads\DfuSe_Demo_V$($args[0])_Setup.exe"
        if (-Not (Test-Path $dfu_install)){
            Expand-Archive -Path "$env:userprofile\Downloads\en.stsw-stm32080.zip" -DestinationPath "$env:userprofile\Downloads"
        }
        Start-Process $dfu_install -Wait
	}else{

        Start-Job -Name "dfu" -ScriptBlock {
            Start-Process "$($args[0])\Bin\DfuSeCommand.exe" -ArgumentList "-c -d --v --fn ""$($args[1])\Web\firmware\can\$($args[2]).dfu""" -PassThru #-RedirectStandardOutput "$env:temp\dfu.log"
        } -ArgumentList $dfu, $(Split-Path $PSScriptRoot -Parent), $args[1] | Wait-Job -Timeout 4 | Out-Null

        #Start-Sleep -Seconds 1
        #Get-Content -Path "$env:temp\dfu.log"
    }
}