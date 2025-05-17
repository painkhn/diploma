export interface User {
    id: number;
    name: string;
    avatar: string;
    email: string;
    email_verified_at?: string;
}

export interface Project {
    id: number;
    user_id: number;
    title: string;
    description: string;
    start_date: Date;
    end_date: Date;
    tasks: Task[] | undefined;
    // projectUser?: User | undefined;
}

export interface Invitation {
    id: number;
    project_id: number;
    sender_id: number;
    recipient_id: nubmer;
    status: string;
    message: string | null;
}

export interface ProjectUser {
    id: number;
    project_id: number;
    user_id: number;
    user: User;
}

export interface Task {
    id: number;
    user_id: number;
    project_id: number;
    responsible_id: nubmer;
    title: string;
    description: string;
    status: string;
    end_date: Date;
    responsible: User;
    reports: Report[] | undefined
}

export interface Report {
    id: number;
    task_id: number;
    user_id: number;
    content: string;
}

export type PageProps<
    T extends Record<string, unknown> = Record<string, unknown>
> = T & {
    auth: {
        user: User;
    };
};
