<?php


class Post extends SplEnum
{
    const __default = self::worker;

    const worker = 1;
    const hr_specialist = 2;
    const manager = 3;
    const accountant = 4;
    const developer = 5;
    const director = 6;
}