<?php

namespace App\Enums\Task;

enum TaskHistoryType: string
{
    case TaskCompleted     = 'task_completed';
    case ExecutorAdded     = 'executor_added';
    case ExecutorRemoved   = 'executor_removed';
    case ExecutorChanged   = 'executor_changed';
    case TaskRejected      = 'task_rejected';
    case TaskSent          = 'task_sent';
    case TaskCreated       = 'task_created';
    case TaskUpdated       = 'task_updated';
}