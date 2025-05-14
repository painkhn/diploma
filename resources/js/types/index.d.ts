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
}

export interface Invitation {
    id: number;
    project_id: number;
    sender_id: number;
    recipient_id: nubmer;
    status: string;
    message: string | null;
}

export type PageProps<
    T extends Record<string, unknown> = Record<string, unknown>
> = T & {
    auth: {
        user: User;
    };
};
