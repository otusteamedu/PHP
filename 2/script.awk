BEGIN{
    FS=" ";
}
{
    cities[$3] += 1;
}
END{
    for(key in cities) {
        print(cities[key], key);
    }
}