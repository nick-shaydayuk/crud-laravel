import React from "react";
import { Inertia } from "@inertiajs/inertia";
import { Table, Container, Button, NavLink } from "react-bootstrap";
import { useTranslation } from "react-i18next";
import ApplicationLogo from '@/Components/ApplicationLogo';
import { Link } from '@inertiajs/react';

interface User {
    id: number;
    name: string;
    email: string;
    gender: string;
    birthday: string;
    avatar: string | null;
    deleted_at: string | null;
    state: string;
}

interface IndexProps {
    people: User[];
}

const Index: React.FC<IndexProps> = ({ people }) => {
    const { t } = useTranslation();

    const handleDelete = (id: number) => {
        Inertia.post(route("people.delete", { id }));
    };

    const handleRestore = (id: number) => {
        Inertia.post(route("people.restore", { id }));
    };

    const handleForceDelete = (id: number) => {
        Inertia.post(route("people.forceDelete", { id }));
    };

    const handleBan = (id: number) => {
        Inertia.post(route("people.ban", { id }));
    };

    const handleUnban = (id: number) => {
        Inertia.post(route("people.unban", { id }));
    };

    return (
        <Container>
            <h1 className="my-4">{t("user_list")}</h1>

            <div className="flex">
                <div className="shrink-0 flex items-center">
                    <Link href="/">
                        <ApplicationLogo className="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    </Link>
                </div>

                <div className="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <NavLink
                        href={route("dashboard")}
                        active={route().current("dashboard")}
                    >
                        Dashboard
                    </NavLink>
                    <NavLink
                        href={route("people.index")}
                        active={route().current("people.index")}
                    >
                        People
                    </NavLink>
                    <NavLink href={route('profile.edit')}>Profile</NavLink>
                </div>
            </div>
            <Button
                variant="primary"
                href={route("people.create")}
                className="mb-3 mt-3"
            >
                {t("create_user")}
            </Button>
            <Table striped bordered hover>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>{t("name")}</th>
                        <th>{t("email")}</th>
                        <th>{t("gender")}</th>
                        <th>{t("birthday")}</th>
                        <th>{t("state")}</th>
                        <th>{t("actions")}</th>
                    </tr>
                </thead>
                <tbody>
                    {people.map((user, index) => (
                        <tr key={user.id}>
                            <td>{index + 1}</td>
                            <td>
                                {user.avatar && (
                                    <img
                                        src={`/storage/${user.avatar}`}
                                        alt="Avatar"
                                        style={{
                                            width: "50px",
                                            height: "50px",
                                            marginRight: "10px",
                                            borderRadius: "50%",
                                            objectFit: "cover",
                                        }}
                                    />
                                )}
                                {user.name}
                            </td>
                            <td>{user.email}</td>
                            <td>{user.gender}</td>
                            <td>
                                {new Date(user.birthday).toLocaleDateString()}
                            </td>
                            <td>
                                {user.state === "App\\States\\Banned"
                                    ? t("banned")
                                    : t("active")}
                            </td>
                            <td>
                                {user.deleted_at ? (
                                    <>
                                        <Button
                                            variant="success"
                                            onClick={() =>
                                                handleRestore(user.id)
                                            }
                                            className="me-2"
                                        >
                                            {t("restore_user")}
                                        </Button>
                                        <Button
                                            variant="danger"
                                            onClick={() =>
                                                handleForceDelete(user.id)
                                            }
                                        >
                                            {t("delete_user_forever")}
                                        </Button>
                                    </>
                                ) : (
                                    <>
                                        <Button
                                            variant="warning"
                                            href={route("people.edit", {
                                                id: user.id,
                                            })}
                                            className="me-2"
                                        >
                                            {t("edit_user")}
                                        </Button>
                                        <Button
                                            variant="danger"
                                            onClick={() =>
                                                handleDelete(user.id)
                                            }
                                            className="me-2"
                                        >
                                            {t("delete_user")}
                                        </Button>
                                        {user.state ===
                                        "App\\States\\Banned" ? (
                                            <Button
                                                variant="success"
                                                onClick={() =>
                                                    handleUnban(user.id)
                                                }
                                            >
                                                {t("unban_user")}
                                            </Button>
                                        ) : (
                                            <Button
                                                variant="danger"
                                                onClick={() =>
                                                    handleBan(user.id)
                                                }
                                            >
                                                {t("ban_user")}
                                            </Button>
                                        )}
                                    </>
                                )}
                            </td>
                        </tr>
                    ))}
                </tbody>
            </Table>
            <h1>rrr</h1>
            {people.map((person) => (
                <p key={person.id}>{JSON.stringify(person, null, 2)}</p>
            ))}
        </Container>
    );
};

export default Index;
