export interface User {
    id: number;
    name: string;
    avatar: string;
    email: string;
    email_verified_at?: string;
    is_owner?: boolean;
    role?: "admin" | "user" | "moderator" | "inspector";
}

export interface Project {
    id: number;
    user_id: number;
    title: string;
    description: string;
    start_date: Date;
    end_date: Date;
    tasks: Task[] | undefined;
    user: User;
    // projectUser?: User | undefined;
}

export interface Invitation {
    id: number;
    project_id: number;
    sender_id: number;
    recipient_id: nubmer;
    status: string;
    message: string | null;
    role: "moderator" | "user" | "inspector";
}

export interface ProjectUser {
    id: number;
    project_id: number;
    user_id: number;
    user: User;
    is_owner?: boolean;
    role: "admin" | "moderator" | "inspector" | "user";
}

export interface Task {
    id: number;
    user_id: number;
    project_id: number;
    responsible_id: nubmer;
    title: string;
    description: string;
    status: string;
    end_date: string;
    responsible: User;
    reports: Report[] | undefined;
    created_at: Date;
    user: User;
}

export interface Report {
    id: number;
    task_id: number;
    user_id: number;
    message: string;
    file_path: string;
    user: User;
}

export interface Friend {
    id: number;
    sender_id: number;
    sender: User;
    receiver_id: number;
    receiver: User;
    status: "pending" | "accepted" | "rejected";
}

export interface ChartDataItem {
    name: string;
    total: number;
    user: {
        id: number;
        name: string;
        email: string;
        is_owner: boolean;
    };
}

export type PageProps<
    T extends Record<string, unknown> = Record<string, unknown>
> = T & {
    auth: {
        user: User;
    };
};
