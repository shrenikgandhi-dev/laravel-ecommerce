import Container from "@/Components/Container";
import { route } from "ziggy-js";
import { PHONE } from "@/Utils/constants";
import NavLink from "@/Components/NavLink";
import styled from "styled-components";

const menus = [
    {
        label: 'help',
        link: route('home'),
    },
    {
        label: 'contact',
        link: route('home'),
    },
    {
        label: 'delivery information',
        link: route('home'),
    },
];

const PrimaryHeader = styled.div`
     background-color: var(--color-accent);
     display: flex;
     .header_top{
        display: flex;
        justify-content: space-between;
        .top_left {
            ul {
                display: flex;
                gap: 15px;
            }
        }
        > * {
            font-size: 14px;
            text-transform: uppercase;
            padding: 6px 0;
            color: var(--color-white);
            a {
                color: var(--color-white);
            }
            a:hover {
                color: var(--color-muted);
            }
        }
     }
`;

export default function Primary() {
    return (
        <PrimaryHeader>
            <Container>
                <nav>
                    <div className="header_top">
                        <div className="top_left">
                            <ul>
                                {
                                    menus.map((val, key) => {
                                        return <>
                                            <li key={key}>
                                                <NavLink to={val.NavLink}>{val.label}</NavLink>
                                            </li> {
                                                key != menus.length - 1 ? <span>|</span> : null
                                            } 
                                        </>
                                    })
                                }
                            </ul>
                        </div>
                        <div className="top_right">
                            Call us : <a href={`tel:${PHONE}`}>{PHONE}</a>
                        </div>
                    </div>
                </nav>
            </Container>
        </PrimaryHeader>
    )
}