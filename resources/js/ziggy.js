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
        "people.index": { uri: "people", methods: ["GET", "HEAD"] },
        "people.create": { uri: "people/create", methods: ["GET", "HEAD"] },
        "people.store": { uri: "people", methods: ["POST"] },
        "people.show": {
            uri: "people/{person}",
            methods: ["GET", "HEAD"],
            parameters: ["person"],
        },
        "people.edit": {
            uri: "people/{person}/edit",
            methods: ["GET", "HEAD"],
            parameters: ["person"],
        },
        "people.update": {
            uri: "people/{person}",
            methods: ["PUT", "PATCH"],
            parameters: ["person"],
        },
        "people.restore": {
            uri: "people/{id}/restore",
            methods: ["POST"],
            parameters: ["id"],
        },
        "people.forceDelete": {
            uri: "people/{id}/force-delete",
            methods: ["DELETE"],
            parameters: ["id"],
        },
        "people.ban": {
            uri: "people/{id}/ban",
            methods: ["PATCH"],
            parameters: ["id"],
        },
        "people.unban": {
            uri: "people/{id}/unban",
            methods: ["PATCH"],
            parameters: ["id"],
        },
        "people.delete": {
            uri: "people/{id}/delete",
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
