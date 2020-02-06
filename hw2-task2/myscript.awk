BEGIN {
  FS=" "
}
# Trim header and empty lines
{ if (( NF > 0 ) && ( NR > 1 )) {
    print $3
  }
}
