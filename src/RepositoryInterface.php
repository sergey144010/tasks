<?php

namespace sergey144010\tasks;


interface RepositoryInterface
{
    public function saveTask(TaskInterface $task);
    public function deleteTask($uuid);
    public function changePriority($uuid, $priority);
    public function changeStatus($uuid, $status);
    public function addTag($uuid, $tag);
    public function deleteTag($uuid, $tag);

    public function getTask($uuid): Task;
    public function getTasks(): array;
    public function getTasksLimit($min, $max);

    public function hasTask($uuid): bool;
}