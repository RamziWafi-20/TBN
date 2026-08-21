import {
    o as e,
    r as t,
    t as n
} from "./jsx-runtime-BMhk9OTh.js";
import {
    E as r,
    b as i
} from "./index-DhrqBnDf.js";
import {
    s as a,
    t as o
} from "./button-CcC8dtDH.js";
import {
    t as s
} from "./bot-C8MgQXIe.js";
import {
    t as c
} from "./coins-CPVBr_xV.js";
import {
    t as l
} from "./leaf-D5k7gyuA.js";
import {
    t as u
} from "./recycle-BuBPdW-I.js";
import {
    t as d
} from "./scan-line-DjekUQRW.js";
var f = a(`arrow-right`, [
        [`path`, {
            d: `M5 12h14`,
            key: `1ays0h`
        }],
        [`path`, {
            d: `m12 5 7 7-7 7`,
            key: `xquz4c`
        }]
    ]),
    p = `/assets/hero-tbn-DTHbnet-.jpg`,
    m = e(t(), 1);

function h() {
    let [e, t] = (0, m.useState)(null), [n, r] = (0, m.useState)(!0);
    return (0, m.useEffect)(() => {
        let {
            data: e
        } = i.auth.onAuthStateChange((e, n) => {
            t(n), r(!1)
        });
        return i.auth.getSession().then(({
            data: e
        }) => {
            t(e.session), r(!1)
        }), () => e.subscription.unsubscribe()
    }, []), {
        session: e,
        user: e ? .user ? ? null,
        loading: n
    }
}
var g = n(),
    _ = [{
        icon: d,
        title: `AI Waste Scanner`,
        desc: `Foto sampah, AI mengenali jenis, material, berat, dan perkiraan nilainya.`
    }, {
        icon: s,
        title: `Eco AI`,
        desc: `Chatbot edukasi sampah, ide produk, dan peluang ekonomi sirkular.`
    }, {
        icon: u,
        title: `Pengelolaan Sampah`,
        desc: `Laporkan sampah, pantau status, dan kelola lewat panel admin.`
    }, {
        icon: c,
        title: `Waste to Value`,
        desc: `Jual atau upcycle, catat pendapatan, dan lihat laporan dampak.`
    }];

function v() {
    let {
        session: e
    } = h();
    return (0, g.jsxs)(`main`, {
        className: `min-h-screen bg-background`,
        "data-tsd-source": `/src/routes/index.tsx:41:5`,
        children: [(0, g.jsxs)(`header`, {
            className: `mx-auto flex max-w-6xl items-center justify-between px-5 py-5`,
            "data-tsd-source": `/src/routes/index.tsx:42:7`,
            children: [(0, g.jsxs)(`div`, {
                className: `flex items-center gap-2`,
                "data-tsd-source": `/src/routes/index.tsx:43:9`,
                children: [(0, g.jsx)(`span`, {
                    className: `flex size-9 items-center justify-center rounded-xl bg-eco-gradient text-primary-foreground`,
                    "data-tsd-source": `/src/routes/index.tsx:44:11`,
                    children: (0, g.jsx)(l, {
                        className: `size-5`,
                        "data-tsd-source": `/src/routes/index.tsx:45:13`
                    })
                }), (0, g.jsx)(`span`, {
                    className: `font-display text-lg font-bold`,
                    "data-tsd-source": `/src/routes/index.tsx:47:11`,
                    children: `TBN`
                })]
            }), (0, g.jsx)(o, {
                asChild: !0,
                size: `sm`,
                "data-tsd-source": `/src/routes/index.tsx:49:9`,
                children: (0, g.jsx)(r, {
                    to: e ? `/beranda` : `/auth`,
                    "data-tsd-source": `/src/routes/index.tsx:50:11`,
                    children: e ? `Buka Aplikasi` : `Masuk`
                })
            })]
        }), (0, g.jsx)(`section`, {
            className: `eco-grid`,
            "data-tsd-source": `/src/routes/index.tsx:54:7`,
            children: (0, g.jsxs)(`div`, {
                className: `mx-auto grid max-w-6xl items-center gap-10 px-5 pt-8 pb-16 md:grid-cols-2 md:pt-16`,
                "data-tsd-source": `/src/routes/index.tsx:55:9`,
                children: [(0, g.jsxs)(`div`, {
                    "data-tsd-source": `/src/routes/index.tsx:56:11`,
                    children: [(0, g.jsxs)(`span`, {
                        className: `inline-flex items-center gap-2 rounded-full border border-border bg-card px-3 py-1 text-xs font-semibold text-primary`,
                        "data-tsd-source": `/src/routes/index.tsx:57:13`,
                        children: [(0, g.jsx)(l, {
                            className: `size-3.5`,
                            "data-tsd-source": `/src/routes/index.tsx:58:15`
                        }), ` Trash Bank Neskar`]
                    }), (0, g.jsxs)(`h1`, {
                        className: `mt-5 text-4xl leading-tight font-extrabold text-balance md:text-6xl`,
                        "data-tsd-source": `/src/routes/index.tsx:60:13`,
                        children: [`Ubah sampah sekolah menjadi `, (0, g.jsx)(`span`, {
                            className: `text-primary`,
                            "data-tsd-source": `/src/routes/index.tsx:61:43`,
                            children: `nilai nyata`
                        }), `.`]
                    }), (0, g.jsx)(`p`, {
                        className: `mt-4 max-w-lg text-base text-muted-foreground`,
                        "data-tsd-source": `/src/routes/index.tsx:63:13`,
                        children: `Satu aplikasi untuk memindai, melaporkan, mengelola, dan menguangkan sampah — didukung AI dan analitik dampak lingkungan.`
                    }), (0, g.jsxs)(`div`, {
                        className: `mt-7 flex flex-wrap gap-3`,
                        "data-tsd-source": `/src/routes/index.tsx:67:13`,
                        children: [(0, g.jsx)(o, {
                            asChild: !0,
                            size: `lg`,
                            "data-tsd-source": `/src/routes/index.tsx:68:15`,
                            children: (0, g.jsxs)(r, {
                                to: e ? `/beranda` : `/auth`,
                                "data-tsd-source": `/src/routes/index.tsx:69:17`,
                                children: [`Mulai sekarang `, (0, g.jsx)(f, {
                                    className: `size-4`,
                                    "data-tsd-source": `/src/routes/index.tsx:70:34`
                                })]
                            })
                        }), (0, g.jsx)(o, {
                            asChild: !0,
                            size: `lg`,
                            variant: `outline`,
                            "data-tsd-source": `/src/routes/index.tsx:73:15`,
                            children: (0, g.jsx)(r, {
                                to: `/auth`,
                                "data-tsd-source": `/src/routes/index.tsx:74:17`,
                                children: `Buat akun`
                            })
                        })]
                    })]
                }), (0, g.jsx)(`div`, {
                    className: `overflow-hidden rounded-3xl shadow-lift`,
                    "data-tsd-source": `/src/routes/index.tsx:78:11`,
                    children: (0, g.jsx)(`img`, {
                        src: p,
                        alt: `Pelajar memilah sampah daur ulang di halaman sekolah`,
                        width: 1600,
                        height: 1e3,
                        className: `h-full w-full object-cover`,
                        "data-tsd-source": `/src/routes/index.tsx:79:13`
                    })
                })]
            })
        }), (0, g.jsxs)(`section`, {
            className: `mx-auto max-w-6xl px-5 pb-20`,
            "data-tsd-source": `/src/routes/index.tsx:90:7`,
            children: [(0, g.jsx)(`h2`, {
                className: `text-2xl font-bold md:text-3xl`,
                "data-tsd-source": `/src/routes/index.tsx:91:9`,
                children: `Fitur utama`
            }), (0, g.jsx)(`div`, {
                className: `mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-4`,
                "data-tsd-source": `/src/routes/index.tsx:92:9`,
                children: _.map(e => (0, g.jsxs)(`div`, {
                    className: `rounded-2xl border border-border bg-card p-5 shadow-card`,
                    "data-tsd-source": `/src/routes/index.tsx:94:13`,
                    children: [(0, g.jsx)(`span`, {
                        className: `flex size-10 items-center justify-center rounded-xl bg-secondary text-secondary-foreground`,
                        "data-tsd-source": `/src/routes/index.tsx:95:15`,
                        children: (0, g.jsx)(e.icon, {
                            className: `size-5`,
                            "data-tsd-source": `/src/routes/index.tsx:96:17`
                        })
                    }), (0, g.jsx)(`h3`, {
                        className: `mt-4 font-semibold`,
                        "data-tsd-source": `/src/routes/index.tsx:98:15`,
                        children: e.title
                    }), (0, g.jsx)(`p`, {
                        className: `mt-1.5 text-sm text-muted-foreground`,
                        "data-tsd-source": `/src/routes/index.tsx:99:15`,
                        children: e.desc
                    })]
                }, e.title))
            })]
        }), (0, g.jsx)(`footer`, {
            className: `border-t border-border py-8 text-center text-sm text-muted-foreground`,
            "data-tsd-source": `/src/routes/index.tsx:105:7`,
            children: `TBN — Trash Bank Neskar · Bank sampah sekolah digital`
        })]
    })
}
export {
    v as component
};