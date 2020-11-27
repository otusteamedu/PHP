<?php

namespace Otus;

use Otus\Answer;

class App
{
    public function run()
    {
        $request = new Post();
        if ($request->string) {
            $validator = new StringValidator($request->string);
            if ($validator->validate()) {
                Answer::correctAnswer('Данные корректны');
            } else {
                Answer::errorAnswer($validator->getError());
            }
        } else {
            Answer::errorAnswer('Не передан POST-параметр string');
        }
    }
}