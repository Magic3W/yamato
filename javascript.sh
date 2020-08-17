#!/bin/sh

wget https://dl.google.com/closure-compiler/compiler-latest.zip
unzip compiler-latest.zip
sudo mv closure-compiler-*.jar /usr/local/bin/closure-compiler
sudo chmod +x /usr/local/bin/closure-compiler
rm compiler-latest.zip COPYING README
