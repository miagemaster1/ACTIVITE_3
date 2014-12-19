set MY_HOME=%~dp0
chdir /D %MY_HOME%

java -cp "bin" -Xrunhprof:cpu=times main.java.org.emiage.SortTab 100000