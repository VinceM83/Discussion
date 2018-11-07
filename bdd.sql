--
-- PostgreSQL database dump
--

-- Dumped from database version 11.0 (Ubuntu 11.0-1.pgdg18.04+2)
-- Dumped by pg_dump version 11.0 (Ubuntu 11.0-1.pgdg18.04+2)

-- Started on 2018-11-05 18:50:23 CET

--

CREATE EXTENSION IF NOT EXISTS pgcrypto WITH SCHEMA public;


--
-- TOC entry 200 (class 1259 OID 16502)
-- Name: channel; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.channel (
    id integer NOT NULL,
    nom character varying(80) NOT NULL,
    idutilisateur integer NOT NULL
);


ALTER TABLE public.channel OWNER TO postgres;

--
-- TOC entry 199 (class 1259 OID 16500)
-- Name: channel_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.channel_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.channel_id_seq OWNER TO postgres;

--
-- TOC entry 3024 (class 0 OID 0)
-- Dependencies: 199
-- Name: channel_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.channel_id_seq OWNED BY public.channel.id;


--
-- TOC entry 204 (class 1259 OID 16539)
-- Name: image; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.image (
    id integer NOT NULL,
    url text NOT NULL,
    envoi timestamp without time zone DEFAULT now() NOT NULL,
    idutilisateur integer NOT NULL,
    idchannel integer NOT NULL
);


ALTER TABLE public.image OWNER TO postgres;

--
-- TOC entry 203 (class 1259 OID 16537)
-- Name: image_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.image_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.image_id_seq OWNER TO postgres;

--
-- TOC entry 3025 (class 0 OID 0)
-- Dependencies: 203
-- Name: image_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.image_id_seq OWNED BY public.image.id;


--
-- TOC entry 202 (class 1259 OID 16517)
-- Name: message; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.message (
    id integer NOT NULL,
    contenu text NOT NULL,
    envoi timestamp without time zone DEFAULT now() NOT NULL,
    idutilisateur integer NOT NULL,
    idchannel integer NOT NULL
);


ALTER TABLE public.message OWNER TO postgres;

--
-- TOC entry 201 (class 1259 OID 16515)
-- Name: message_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.message_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.message_id_seq OWNER TO postgres;

--
-- TOC entry 3026 (class 0 OID 0)
-- Dependencies: 201
-- Name: message_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.message_id_seq OWNED BY public.message.id;


--
-- TOC entry 198 (class 1259 OID 16492)
-- Name: utilisateur; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.utilisateur (
    id integer NOT NULL,
    pseudo character varying(60) NOT NULL,
    mdp character varying(96) NOT NULL
);


ALTER TABLE public.utilisateur OWNER TO postgres;

--
-- TOC entry 197 (class 1259 OID 16490)
-- Name: utilisateur_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.utilisateur_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.utilisateur_id_seq OWNER TO postgres;

--
-- TOC entry 3027 (class 0 OID 0)
-- Dependencies: 197
-- Name: utilisateur_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.utilisateur_id_seq OWNED BY public.utilisateur.id;


--
-- TOC entry 2867 (class 2604 OID 16505)
-- Name: channel id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.channel ALTER COLUMN id SET DEFAULT nextval('public.channel_id_seq'::regclass);


--
-- TOC entry 2870 (class 2604 OID 16542)
-- Name: image id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.image ALTER COLUMN id SET DEFAULT nextval('public.image_id_seq'::regclass);


--
-- TOC entry 2868 (class 2604 OID 16520)
-- Name: message id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.message ALTER COLUMN id SET DEFAULT nextval('public.message_id_seq'::regclass);


--
-- TOC entry 2866 (class 2604 OID 16495)
-- Name: utilisateur id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.utilisateur ALTER COLUMN id SET DEFAULT nextval('public.utilisateur_id_seq'::regclass);


--
-- TOC entry 2877 (class 2606 OID 16509)
-- Name: channel channel_nom_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.channel
    ADD CONSTRAINT channel_nom_key UNIQUE (nom);


--
-- TOC entry 2879 (class 2606 OID 16507)
-- Name: channel channel_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.channel
    ADD CONSTRAINT channel_pkey PRIMARY KEY (id);


--
-- TOC entry 2883 (class 2606 OID 16548)
-- Name: image image_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.image
    ADD CONSTRAINT image_pkey PRIMARY KEY (id);


--
-- TOC entry 2881 (class 2606 OID 16526)
-- Name: message message_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.message
    ADD CONSTRAINT message_pkey PRIMARY KEY (id);


--
-- TOC entry 2873 (class 2606 OID 16497)
-- Name: utilisateur utilisateur_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.utilisateur
    ADD CONSTRAINT utilisateur_pkey PRIMARY KEY (id);


--
-- TOC entry 2875 (class 2606 OID 16499)
-- Name: utilisateur utilisateur_pseudo_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.utilisateur
    ADD CONSTRAINT utilisateur_pseudo_key UNIQUE (pseudo);


--
-- TOC entry 2884 (class 2606 OID 16510)
-- Name: channel channel_idutilisateur_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.channel
    ADD CONSTRAINT channel_idutilisateur_fkey FOREIGN KEY (idutilisateur) REFERENCES public.utilisateur(id);


--
-- TOC entry 2888 (class 2606 OID 16554)
-- Name: image image_idchannel_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.image
    ADD CONSTRAINT image_idchannel_fkey FOREIGN KEY (idchannel) REFERENCES public.channel(id);


--
-- TOC entry 2887 (class 2606 OID 16549)
-- Name: image image_idutilisateur_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.image
    ADD CONSTRAINT image_idutilisateur_fkey FOREIGN KEY (idutilisateur) REFERENCES public.utilisateur(id);


--
-- TOC entry 2886 (class 2606 OID 16532)
-- Name: message message_idchannel_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.message
    ADD CONSTRAINT message_idchannel_fkey FOREIGN KEY (idchannel) REFERENCES public.channel(id);


--
-- TOC entry 2885 (class 2606 OID 16527)
-- Name: message message_idutilisateur_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.message
    ADD CONSTRAINT message_idutilisateur_fkey FOREIGN KEY (idutilisateur) REFERENCES public.utilisateur(id);


-- Completed on 2018-11-05 18:50:23 CET

--
-- PostgreSQL database dump complete
--

