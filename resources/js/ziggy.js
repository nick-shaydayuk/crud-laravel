const Ziggy = {
    url: "http://localhost:3001",
    port: 3001,
    defaults: {},
    routes: {
        "sanctum.csrf-cookie": {
            uri: "sanctum/csrf-cookie",
            methods: ["GET", "HEAD"],
        },
        "ignition.healthCheck": {
            uri: "_ignition/health-check",
            methods: ["GET", "HEAD"],
        },
        "ignition.executeSolution": {
            uri: "_ignition/execute-solution",
            methods: ["POST"],
        },
        "ignition.updateConfig": {
            uri: "_ignition/update-config",
            methods: ["POST"],
        },
        dashboard: { uri: "dashboard", methods: ["GET", "HEAD"] },
        "profile.edit": { uri: "profile", methods: ["GET", "HEAD"] },
        "profile.update": { uri: "profile", methods: ["PATCH"] },
        "profile.destroy": { uri: "profile", methods: ["DELETE"] },
        "person.index": { uri: "person", methods: ["GET", "HEAD"] },
        "person.create": { uri: "person/create", methods: ["GET", "HEAD"] },
        "person.store": { uri: "person", methods: ["POST"] },
        "person.show": {
            uri: "person/{person}",
            methods: ["GET", "HEAD"],
            parameters: ["person"],
        },
        "person.edit": {
            uri: "person/{person}/edit",
            methods: ["GET", "HEAD"],
            parameters: ["person"],
        },
        "person.update": {
            uri: "person/{person}",
            methods: ["PUT", "PATCH"],
            parameters: ["person"],
        },
        "person.restore": {
            uri: "person/{id}/restore",
            methods: ["POST"],
            parameters: ["id"],
        },
        "person.forceDelete": {
            uri: "person/{id}/force-delete",
            methods: ["DELETE"],
            parameters: ["id"],
        },
        "person.ban": {
            uri: "person/{id}/ban",
            methods: ["PATCH"],
            parameters: ["id"],
        },
        "person.unban": {
            uri: "person/{id}/unban",
            methods: ["PATCH"],
            parameters: ["id"],
        },
        "person.delete": {
            uri: "person/{id}/delete",
            methods: ["DELETE"],
            parameters: ["id"],
        },
        register: { uri: "register", methods: ["GET", "HEAD"] },
        login: { uri: "login", methods: ["GET", "HEAD"] },
        "password.request": {
            uri: "forgot-password",
            methods: ["GET", "HEAD"],
        },
        "password.email": { uri: "forgot-password", methods: ["POST"] },
        "password.reset": {
            uri: "reset-password/{token}",
            methods: ["GET", "HEAD"],
            parameters: ["token"],
        },
        "password.store": { uri: "reset-password", methods: ["POST"] },
        "verification.notice": {
            uri: "verify-email",
            methods: ["GET", "HEAD"],
        },
        "verification.verify": {
            uri: "verify-email/{id}/{hash}",
            methods: ["GET", "HEAD"],
            parameters: ["id", "hash"],
        },
        "verification.send": {
            uri: "email/verification-notification",
            methods: ["POST"],
        },
        "password.confirm": {
            uri: "confirm-password",
            methods: ["GET", "HEAD"],
        },
        "password.update": { uri: "password", methods: ["PUT"] },
        logout: { uri: "logout", methods: ["POST"] },
    },
};
if (typeof window !== "undefined" && typeof window.Ziggy !== "undefined") {
    Object.assign(Ziggy.routes, window.Ziggy.routes);
}
export { Ziggy };
