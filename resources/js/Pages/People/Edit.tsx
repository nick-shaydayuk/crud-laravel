import React, { useEffect } from "react";
import { useForm } from "@inertiajs/inertia-react";
import { Form, Button, Container } from "react-bootstrap";
import { useTranslation } from "react-i18next";

interface User {
    id: number;
    name: string;
    email: string;
    gender: string;
    birthday: string;
    avatar: string | null;
}

interface EditProps {
    user: User;
}

const Edit: React.FC<EditProps> = ({ user }) => {
    const { t } = useTranslation();
    const { data, setData, patch, processing, errors } = useForm({
        name: user.name,
        email: user.email,
        gender: user.gender === "Мужской" ? "male" : "female",
        birthday: user.birthday,
        avatar: null as File | null,
    });

    useEffect(() => {
        console.log(data.avatar);
        
    }, [data])

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        const formData = new FormData();
        Object.keys(data).forEach(key => {
            formData.append(key, data[key as keyof typeof data] as string | Blob);
        });
        patch(route('people.update', { id: user.id }), {
            data: formData,
            headers: {
                'X-HTTP-Method-Override': 'PUT'
            }
        });
    };

    return (
        <Container>
            <h1 className="my-4">{t('edit_user')}</h1>
            <Form onSubmit={handleSubmit}>
                <Form.Group className="mb-3">
                    <Form.Label>{t('name')}</Form.Label>
                    <Form.Control
                        type="text"
                        value={data.name}
                        onChange={(e: React.ChangeEvent<HTMLInputElement>) => setData("name", e.target.value)}
                        placeholder={t('name')}
                        required
                    />
                    {errors.name && <div className="text-danger">{errors.name}</div>}
                </Form.Group>
                <Form.Group className="mb-3">
                    <Form.Label>{t('email')}</Form.Label>
                    <Form.Control
                        type="email"
                        value={data.email}
                        onChange={(e: React.ChangeEvent<HTMLInputElement>) => setData("email", e.target.value)}
                        placeholder={t('email')}
                        required
                    />
                    {errors.email && <div className="text-danger">{errors.email}</div>}
                </Form.Group>
                <Form.Group className="mb-3">
                    <Form.Label>{t('gender')}</Form.Label>
                    <Form.Select
                        value={data.gender}
                        onChange={(e: React.ChangeEvent<HTMLSelectElement>) => setData("gender", e.target.value)}
                        required
                    >
                        <option value="male">{t('male')}</option>
                        <option value="female">{t('female')}</option>
                    </Form.Select>
                    {errors.gender && <div className="text-danger">{errors.gender}</div>}
                </Form.Group>
                <Form.Group className="mb-3">
                    <Form.Label>{t('birthday')}</Form.Label>
                    <Form.Control
                        type="date"
                        value={data.birthday}
                        onChange={(e: React.ChangeEvent<HTMLInputElement>) => setData("birthday", e.target.value)}
                        required
                    />
                    {errors.birthday && <div className="text-danger">{errors.birthday}</div>}
                </Form.Group>
                <Form.Group className="mb-3">
                    <Form.Label>{t('avatar')}</Form.Label>
                    <Form.Control
                        type="file"
                        onChange={(e: React.ChangeEvent<HTMLInputElement>) => setData("avatar", e.target.files ? e.target.files[0] : null)}
                    />
                    {errors.avatar && <div className="text-danger">{errors.avatar}</div>}
                    {user.avatar && <img src={`/storage/${user.avatar}`} alt="Avatar" style={{ width: '100px', marginTop: '10px' }} />}
                </Form.Group>
                <Button variant="primary" type="submit" disabled={processing}>
                    {t('save')}
                </Button>
            </Form>
        </Container>
    );
};

export default Edit;
