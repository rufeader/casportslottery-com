<?php

/**
 * 站点元信息管理示例
 * 演示如何用数组保存站点配置并提供描述生成能力
 */

class SiteMetaManager
{
    private array $metaData;

    public function __construct(array $initialMeta = [])
    {
        $this->metaData = $initialMeta ?: $this->getDefaultMeta();
    }

    private function getDefaultMeta(): array
    {
        return [
            'site_name'        => '中国体育彩票信息站',
            'domain'           => 'https://casportslottery.com',
            'keywords'         => ['中国体育彩票', '体育彩票', '彩票资讯', '开奖结果'],
            'description'      => '提供中国体育彩票相关资讯、开奖结果查询及玩法介绍。',
            'lang'             => 'zh-CN',
            'author'           => '信息团队',
            'version'          => '1.0.0',
            'contact_email'    => 'info@casportslottery.com',
            'last_updated'     => '2025-03-01',
            'features'         => [
                'lottery_results' => true,
                'news_section'    => true,
                'statistics'      => false,
            ],
        ];
    }

    /**
     * 生成简短的站点描述文本
     * @param int $maxLength 最大字符长度
     * @return string
     */
    public function generateShortDescription(int $maxLength = 120): string
    {
        $name = $this->metaData['site_name'] ?? '站点';
        $domain = $this->metaData['domain'] ?? '';
        $keywords = $this->metaData['keywords'] ?? [];
        $desc = $this->metaData['description'] ?? '';

        $parts = [];
        $parts[] = $name;
        if ($desc) {
            $parts[] = $desc;
        }
        if (!empty($keywords)) {
            $keywordStr = implode('、', array_slice($keywords, 0, 3));
            $parts[] = '关键词：' . $keywordStr;
        }
        if ($domain) {
            $parts[] = '官网：' . $domain;
        }

        $combined = implode(' — ', $parts);

        if (mb_strlen($combined) > $maxLength) {
            $combined = mb_substr($combined, 0, $maxLength - 3) . '...';
        }

        return $combined;
    }

    /**
     * 获取完整元数据数组
     * @return array
     */
    public function getAllMeta(): array
    {
        return $this->metaData;
    }

    /**
     * 获取单个字段
     * @param string $key
     * @return mixed|null
     */
    public function getField(string $key)
    {
        return $this->metaData[$key] ?? null;
    }

    /**
     * 输出 HTML 元标签（示例用法）
     * @return string
     */
    public function renderMetaTags(): string
    {
        $name = htmlspecialchars($this->metaData['site_name'] ?? '', ENT_QUOTES, 'UTF-8');
        $desc = htmlspecialchars($this->metaData['description'] ?? '', ENT_QUOTES, 'UTF-8');
        $keywords = htmlspecialchars(implode(',', $this->metaData['keywords'] ?? []), ENT_QUOTES, 'UTF-8');
        $domain = htmlspecialchars($this->metaData['domain'] ?? '', ENT_QUOTES, 'UTF-8');

        $tags = '';
        $tags .= '<meta name="description" content="' . $desc . '" />' . "\n";
        $tags .= '<meta name="keywords" content="' . $keywords . '" />' . "\n";
        $tags .= '<meta name="author" content="' . htmlspecialchars($this->metaData['author'] ?? '', ENT_QUOTES, 'UTF-8') . '" />' . "\n";
        $tags .= '<link rel="canonical" href="' . $domain . '" />' . "\n";
        return $tags;
    }
}

// ===== 示例使用 =====

$siteMeta = new SiteMetaManager();

echo "站点描述（默认长度）：\n";
echo $siteMeta->generateShortDescription() . "\n\n";

echo "站点描述（限制60字符）：\n";
echo $siteMeta->generateShortDescription(60) . "\n\n";

echo "渲染的 Meta 标签：\n";
echo $siteMeta->renderMetaTags() . "\n";

echo "全部元数据：\n";
print_r($siteMeta->getAllMeta());