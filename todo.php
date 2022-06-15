<?php

$data = json_decode(file_get_contents('php://input'));

if(isset($data->method))
{
    switch($data->method)
    {
        case 'GET_LIST':
        {
            print(file_get_contents('list.json'));
        }break;
        case 'EDIT_TASK':
        {
            $tasks = json_decode(file_get_contents('list.json'));
            
            if(isset($tasks[(int)$data->id]))
            {
                $tasks[(int)$data->id] = $data->task;
            }
            
            $tmpTasks = [];

            foreach($tasks as $task)
            {
                $tmpTasks[] = $task;
            }
            
            file_put_contents('list.json', json_encode($tmpTasks));
        }break;
        case 'NEW_TASK':
        {
            $tasks = json_decode(file_get_contents('list.json'));
            
            $tmpTasks = [];

            foreach($tasks as $task)
            {
                $tmpTasks[] = $task;
            }

            $tmpTasks[] = $data->task;

            file_put_contents('list.json', json_encode($tmpTasks));
        }break;
        case 'DELETE_TASK':
        {
            $tasks = json_decode(file_get_contents('list.json'));

            unset($tasks[(int)$data->id]);
            
            $tmpTasks = [];

            foreach($tasks as $task)
            {
                $tmpTasks[] = $task;
            }

            file_put_contents('list.json', json_encode($tmpTasks));
        }break;
    }
}
