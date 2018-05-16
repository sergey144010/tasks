<?php

namespace sergey144010\tasks;


use sergey144010\tasks\Exception\ErrorInsertIntoTasks;
use sergey144010\tasks\Exception\ErrorInsertIntoTasksTags;
use sergey144010\tasks\Exception\TaskException;
use sergey144010\tasks\TaskSpares\Identity;
use sergey144010\tasks\TaskSpares\Name;
use sergey144010\tasks\TaskSpares\Priority;
use sergey144010\tasks\TaskSpares\Status;

class TaskRepository extends Repository
{
    /**
     * @param TaskInterface $task
     * @return null
     * @throws TaskException
     */
    public function saveTask(TaskInterface $task)
    {
        $uuid = $task->getIdentity();
        $name = $task->getName();
        $priority = $task->getPriority();
        $status = $task->getStatus();
        $tags = $task->getTags();

        $this->pdo->beginTransaction();
        $stmt = $this->pdo->prepare("INSERT INTO tasks (uuid, name, priority, status) VALUES (:uuid, :name, :priority, :status);");

        $stmt->bindParam(':uuid', $uuid);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':priority', $priority);
        $stmt->bindParam(':status', $status);
        if(!$stmt->execute()){
            throw new ErrorInsertIntoTasks('Error insert in tasks table');
        };

        $tags = array_filter($tags, [Helper::class, 'isEmptyVar']);
        if(!empty($tags)){
            $tag = null;
            $stmt = $this->pdo->prepare("INSERT INTO tasks_tags (uuid, tag) VALUES (:uuid, :tag);");
            $stmt->bindParam(':uuid', $uuid);
            $stmt->bindParam(':tag', $tag);
            foreach ($tags as $tag){
                if(!$stmt->execute()){
                    $this->pdo->rollBack();
                    throw new ErrorInsertIntoTasksTags('Error insert in tasks_tags table');
                };
            };
        };
        $this->pdo->commit();
    }

    public function deleteTask($uuid)
    {
        $stmt = $this->pdo->prepare("DELETE FROM tasks WHERE uuid = :uuid");
        $stmt->bindParam(':uuid', $uuid);
        return $stmt->execute();
    }

    public function changePriority($uuid, $priority)
    {
        $stmt = $this->pdo->prepare("UPDATE tasks SET priority = :priority WHERE uuid = :uuid");
        $stmt->bindParam(':uuid', $uuid);
        $stmt->bindParam(':priority', $priority);
        return $stmt->execute();
    }

    public function changeStatus($uuid, $status)
    {
        $stmt = $this->pdo->prepare("UPDATE tasks SET status = :status WHERE uuid = :uuid");
        $stmt->bindParam(':uuid', $uuid);
        $stmt->bindParam(':status', $status);
        return $stmt->execute();
    }

    public function addTag($uuid, $tag)
    {
        $stmt = $this->pdo->prepare("INSERT INTO tasks_tags (uuid, tag) VALUES (:uuid, :tag);");
        $stmt->bindParam(':uuid', $uuid);
        $stmt->bindParam(':tag', $tag);
        return $stmt->execute();
    }

    public function deleteTag($uuid, $tag)
    {
        // TODO: Implement deleteTag() method.
    }

    public function getTask($uuid): Task
    {
        $stmt = $this->pdo->prepare("SELECT * FROM tasks WHERE uuid = :uuid;");
        $stmt->bindParam(':uuid', $uuid);
        $stmt->execute();
        $row = $stmt->fetchAll();
        #return $row[0]['name'];
        $task =  new Task(
            new Name($row[0]['name']),
            new Identity($row[0]['uuid']),
            new Priority($row[0]['priority']),
            new Status($row[0]['status'])
        );
        $stmt = $this->pdo->prepare("SELECT tag FROM tasks_tags WHERE uuid = :uuid;");
        $stmt->bindParam(':uuid', $uuid);
        $stmt->execute();
        $row = $stmt->fetchAll();
        if(empty($row)){
            $task->setTags($row);
        }else{
            $out = [];
            foreach ($row as $arr) {
                $out[] = $arr['tag'];
            };
            $task->setTags($out);
        }
        return $task;
    }

    public function getTasks(): array
    {
        $out = [];
        $statuses = [1,0];
        foreach ($statuses as $status) {
            $sql = "SELECT * FROM tasks WHERE status = '".$status."' ORDER BY priority DESC;";
            foreach ($this->pdo->query($sql)->fetchAll(\PDO::FETCH_ASSOC) as $row) {
                $outtag = [];
                $sql = "SELECT * FROM tasks_tags WHERE uuid = '{$row['uuid']}';";
                $query = $this->pdo->query($sql);
                if($query){
                    foreach ($query as $rowtag) {
                        $outtag[] = $rowtag['tag'];
                    };
                };
                $out[] = $row;
                $key = key($out);
                $out[$key]['tags'] = $outtag;
                next($out);
            };
        };
        return $out;
    }

    public function getTasksLimit($min, $max)
    {
        // TODO: Implement getTasksLimit() method.
    }

    public function hasTask($uuid): bool
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM tasks WHERE uuid = :uuid;");
        $stmt->bindParam(':uuid', $uuid);
        $stmt->execute();
        $row = $stmt->fetchAll(\PDO::FETCH_NUM);
        if($row[0][0] == 0){
            return false;
        }else{
            return true;
        }
    }

    public function getUUID()
    {
        $sql = 'SELECT * FROM tasks;';
        $out = [];
        foreach ($this->pdo->query($sql) as $row) {
            $out[] = $row['uuid'];
        };
        return $out;
    }

    public function search(string $name)
    {
        return $this->getTasksSearch($name);
    }

    public function getTasksSearch($search = null): array
    {

        $out = [];
        $statuses = [1,0];
        foreach ($statuses as $status) {

            if(isset($search)){
                $sql = "SELECT * FROM tasks WHERE status = '".$status."' and name LIKE '%".$search."%' ORDER BY priority DESC;";
            }else{
                $sql = "SELECT * FROM tasks WHERE status = '".$status."' ORDER BY priority DESC;";
            };

            foreach ($this->pdo->query($sql)->fetchAll(\PDO::FETCH_ASSOC) as $row) {
                $outtag = [];
                $sql = "SELECT * FROM tasks_tags WHERE uuid = '{$row['uuid']}';";
                $query = $this->pdo->query($sql);
                if($query){
                    foreach ($query as $rowtag) {
                        $outtag[] = $rowtag['tag'];
                    };
                };
                $out[] = $row;
                $key = key($out);
                $out[$key]['tags'] = $outtag;
                next($out);
            };
        };
        return $out;
    }

}