# Simple shell script to build docs

echo "Run Doxyfile"
/usr/bin/doxygen Doxyfile

echo "run Doxyphp2sphinx"
/usr/local/bin/doxyphp2sphinx Ouxsoft::LivingMarkup

echo "Complete"