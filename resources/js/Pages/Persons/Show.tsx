import React from "react";
import { useForm } from "@inertiajs/react";
import { Form, Container } from "react-bootstrap";
import { useTranslation } from "react-i18next";

interface Person {
    id: number;
    name: string;
    email: string;
    gender: string;
    birthday: string;
    avatar: string | null;
}

interface EditProps {
    person: Person;
}

const Edit: React.FC<EditProps> = ({ person }) => {    
    const { t } = useTranslation();
    const { data, setData } = useForm({
        name: person.name ?? '',
        email: person.email ?? '',
        gender: person.gender ?? 'male',
        birthday: person.birthday ?? '2000-01-01',
        avatar: person.avatar ?? null as File | null,
    });


    return (
        <Container>
            <h1 className="my-4">{t('show_user')}</h1>
            <Form noValidate>
                <Form.Group className="mb-3">
                    <Form.Label>{t('name')}</Form.Label>
                    <Form.Control
                        type="text"
                        value={data.name}
                        placeholder={t('name')}
                        readOnly
                    />
                </Form.Group>
                <Form.Group className="mb-3">
                    <Form.Label>{t('email')}</Form.Label>
                    <Form.Control
                        type="email"
                        value={data.email}
                        onChange={(e: React.ChangeEvent<HTMLInputElement>) => setData("email", e.target.value)}
                        placeholder={t('email')}
                        readOnly
                    />
                </Form.Group>
                <Form.Group className="mb-3">
                    <Form.Label>{t('gender')}</Form.Label>
                    <Form.Control
                        value={data.gender}
                        type="text"
                        readOnly                        
                    >
                    </Form.Control>
                </Form.Group>
                <Form.Group className="mb-3">
                    <Form.Label>{t('birthday')}</Form.Label>
                    <Form.Control
                        type="date"
                        value={data.birthday}
                        readOnly
                    />
                </Form.Group>
                <Form.Group className="mb-3">
                    <Form.Label>{t('avatar')}</Form.Label>
                    <Form.Control
                        type="file"
                        readOnly
                    />
                    {person.avatar && <img src={`/storage/${person.avatar}`} alt="Avatar" style={{ width: '100px', marginTop: '10px' }} />}
                </Form.Group>
             </Form>
        </Container>
    );
};

export default Edit;
