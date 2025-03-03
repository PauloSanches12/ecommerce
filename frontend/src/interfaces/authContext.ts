export interface AuthContextType {
    authToken: string | null;
    user: { email: string } | null;
    setAuthToken: (token: string | null, user: { email: string } | null) => void;
    logout: () => void;
}