function getTree(array, id, id_parent) {
    let h = {},res = [];

    array.forEach((x) => {
        h[x.id] = x, x.children = []
    })
    array.forEach((x) => {
        x.id_parent ? h[x.id_parent].children.push(x) : res.push(x)
    });

    return res;
}
