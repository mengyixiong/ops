export function useTool() {
  function extractIdsFromTree(tree) {
    const ids = [];

    function recurse(nodes) {
      for (const node of nodes) {
        ids.push(node.id); // 将当前节点的 id 加入数组
        if (node.children) {
          recurse(node.children); // 如果有子节点，递归遍历子节点
        }
      }
    }

    recurse(tree); // 开始递归遍历
    return ids; // 返回所有 id 的数组
  }

  function findPathToNode(tree, targetId) {

    let findNode = null;
    tree.forEach(node => {
      if (node.id === targetId){
        findNode = node;
      }

      // 如果有子节点，递归遍历子节点
      if (node.children && node.children.length > 0) {
        return findPathToNode(node.children, targetId);
      }
    });
    return findNode;
  }

  function assignMatchingProperties(source, target): void {
    for (const key in target) {
      if (key in source && key in target) {
        target[key] = source[key];
      }
    }
  }

  return {
    extractIdsFromTree,
    findPathToNode,
    assignMatchingProperties
  };
}
