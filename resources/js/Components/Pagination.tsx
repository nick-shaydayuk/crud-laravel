import { Link } from "@inertiajs/react";

interface PaginationProps {
  links: { 
    label: string,
    url: string | null
   }[];
}

const Pagination: React.FC<PaginationProps> = ({ links }) => {
  return (
    <>
      {links.map((link) => (
        // <Link key={link.label} href="" >{link.label}</Link> 
        // Пример ниже показывает, как можно преобразовать ссылки
        <Link key={link.label} href={link.url || ""} 
          dangerouslySetInnerHTML={{ __html: link.label}}
          className="me-2"></Link>
      ))}
    </>
  );
}

export default Pagination;
