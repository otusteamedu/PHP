BEGIN {
    FS=" "
}
{
    # skip header
    if ( NR > 1 ) {
        # print city
        print $3
    }
}