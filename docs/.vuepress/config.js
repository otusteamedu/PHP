module.exports = {
    title: 'Docs',
    head: [
        // ['link', {rel: 'icon', href: '/favicon.ico'}]
    ],
    themeConfig: {
        navbar: true,
        sidebar: [
            '/',
            '/second.html',
            '/foo/',
            '/foo/bar.html',
        ]
    },
    markdown: {
        // options for markdown-it-anchor
        anchor: {permalink: false},
        // extendMarkdown: md => {
        //     // use more markdown-it plugins!
        //     md.use(require('markdown-it-xxx'))
        // },
        // options for markdown-it-toc
        toc: {includeLevel: [1, 2]}
    }
};
