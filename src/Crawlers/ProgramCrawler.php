<?php

declare(strict_types=1);

namespace BVP\Crawler\Crawlers;

use BVP\Converter\Converter;
use BVP\Trimmer\Trimmer;
use Carbon\CarbonInterface;
use Symfony\Component\DomCrawler\Crawler;

/**
 * @author shimomo
 */
class ProgramCrawler extends BaseCrawler implements ProgramCrawlerInterface
{
    /**
     * @var string
     */
    private string $baseXPath = 'descendant-or-self::body/main/div/div/div';

    /**
     * @param  \Carbon\CarbonInterface  $carbonDate
     * @param  int                      $raceStadiumCode
     * @param  int                      $raceCode
     * @return array
     */
    public function crawl(CarbonInterface $carbonDate, int $raceStadiumCode, int $raceCode): array
    {
        $response = [];

        $crawlerFormat = '%s/owpc/pc/race/racelist?hd=%s&jcd=%02d&rno=%d';
        $crawlerUrl = sprintf($crawlerFormat, $this->baseUrl, $carbonDate->format('Ymd'), $raceStadiumCode, $raceCode);
        $crawler = $this->httpBrowser->request('GET', $crawlerUrl);
        sleep($this->seconds);

        $levelFormat = '%s/div[2]/div[3]/ul/li';
        $levelXPath = sprintf($levelFormat, $this->baseXPath);

        $this->baseLevel = 0;
        if (!is_null($this->filterXPath($crawler, $levelXPath))) {
            $this->baseLevel = 1;
        }

        $raceTitleFormat = '%s/div[1]/div/div[2]/h2';
        $raceSubtitleDistanceFormat = '%s/div[2]/div[%s]/h3';
        $raceDeadlineFormat = '%s/div[2]/div[2]/table/tbody/tr[1]/td[%s]';

        $raceTitleXPath = sprintf($raceTitleFormat, $this->baseXPath);
        $raceSubtitleDistanceXPath = sprintf($raceSubtitleDistanceFormat, $this->baseXPath, $this->baseLevel + 3);
        $raceDeadlineXPath = sprintf($raceDeadlineFormat, $this->baseXPath, $raceCode + 1);

        $raceTitle = $this->filterXPath($crawler, $raceTitleXPath);
        $raceSubtitleDistance = $this->filterXPath($crawler, $raceSubtitleDistanceXPath);
        $raceDeadline = $this->filterXPath($crawler, $raceDeadlineXPath);

        $raceClosedAt = null;
        if (!is_null($raceDeadline)) {
            $raceClosedAt = $carbonDate->setTimeFromTimeString($raceDeadline)->format('Y-m-d H:i:s');
        }

        [$raceSubtitle, $raceDistance] = $this->explodeSubtitleDistance($raceSubtitleDistance);

        $response['race_date'] = $carbonDate->format('Y-m-d');
        $response['race_stadium_code'] = $raceStadiumCode;
        $response['race_code'] = $raceCode;
        $response['race_closed_at'] = $raceClosedAt;
        $response['race_title'] = $raceTitle;
        $response['race_subtitle'] = $raceSubtitle;
        $response['race_distance'] = $raceDistance;

        $response += $this->crawlBoats($crawler, $raceStadiumCode, $raceCode);

        return $response;
    }

    /**
     * @param  \Symfony\Component\DomCrawler\Crawler  $crawler
     * @param  int                                    $raceStadiumCode
     * @param  int                                    $raceCode
     * @return array
     */
    private function crawlBoats(Crawler $crawler, int $raceStadiumCode, int $raceCode): array
    {
        $response = [];

        $racerBoatNumberFormat = '%s/div[2]/div[%s]/table/tbody[%s]/tr[1]/td[1]';
        $racerNameFormat = '%s/div[2]/div[%s]/table/tbody[%s]/tr[1]/td[3]/div[2]/a';
        $racerNumberClassFormat = '%s/div[2]/div[%s]/table/tbody[%s]/tr[1]/td[3]/div[1]';
        $racerBranchBirthplaceAgeWeightFormat = '%s/div[2]/div[%s]/table/tbody[%s]/tr[1]/td[3]/div[3]';
        $racerFlyingLateStartTimingFormat = '%s/div[2]/div[%s]/table/tbody[%s]/tr[1]/td[4]';
        $racerNationalTop123PercentFormat = '%s/div[2]/div[%s]/table/tbody[%s]/tr[1]/td[5]';
        $racerLocalTop123PercentFormat = '%s/div[2]/div[%s]/table/tbody[%s]/tr[1]/td[6]';
        $racerAssignedMotorNumberMotorTop23PercentFormat = '%s/div[2]/div[%s]/table/tbody[%s]/tr[1]/td[7]';
        $racerAssignedBoatNumberBoatTop23PercentFormat = '%s/div[2]/div[%s]/table/tbody[%s]/tr[1]/td[8]';

        foreach (range(1, 6) as $index) {
            $racerBoatNumberXPath = sprintf($racerBoatNumberFormat, $this->baseXPath, $this->baseLevel + 5, $index);
            $racerNameXPath = sprintf($racerNameFormat, $this->baseXPath, $this->baseLevel + 5, $index);
            $racerNumberClassXPath = sprintf($racerNumberClassFormat, $this->baseXPath, $this->baseLevel + 5, $index);
            $racerBranchBirthplaceAgeWeightXPath = sprintf($racerBranchBirthplaceAgeWeightFormat, $this->baseXPath, $this->baseLevel + 5, $index);
            $racerFlyingLateStartTimingXPath = sprintf($racerFlyingLateStartTimingFormat, $this->baseXPath, $this->baseLevel + 5, $index);
            $racerNationalTop123PercentXPath = sprintf($racerNationalTop123PercentFormat, $this->baseXPath, $this->baseLevel + 5, $index);
            $racerLocalTop123PercentXPath = sprintf($racerLocalTop123PercentFormat, $this->baseXPath, $this->baseLevel + 5, $index);
            $racerAssignedMotorNumberMotorTop23PercentXPath = sprintf($racerAssignedMotorNumberMotorTop23PercentFormat, $this->baseXPath, $this->baseLevel + 5, $index);
            $racerAssignedBoatNumberMotorTop23PercentXPath = sprintf($racerAssignedBoatNumberBoatTop23PercentFormat, $this->baseXPath, $this->baseLevel + 5, $index);

            $racerBoatNumber = $this->filterXPath($crawler, $racerBoatNumberXPath);
            $racerName = $this->filterXPath($crawler, $racerNameXPath);
            $racerNumberClass = $this->filterXPath($crawler, $racerNumberClassXPath);
            $racerBranchBirthplaceAgeWeight = $this->filterXPath($crawler, $racerBranchBirthplaceAgeWeightXPath);
            $racerFlyingLateStartTiming = $this->filterXPath($crawler, $racerFlyingLateStartTimingXPath);
            $racerNationalTop123Percent = $this->filterXPath($crawler, $racerNationalTop123PercentXPath);
            $racerLocalTop123Percent = $this->filterXPath($crawler, $racerLocalTop123PercentXPath);
            $racerAssignedMotorNumberMotorTop23Percent = $this->filterXPath($crawler, $racerAssignedMotorNumberMotorTop23PercentXPath);
            $racerAssignedBoatNumberBoatTop23Percent = $this->filterXPath($crawler, $racerAssignedBoatNumberMotorTop23PercentXPath);

            $racerBoatNumber = Converter::int($racerBoatNumber ?? $index);
            $racerName = Converter::name($racerName);

            [$racerNumber, $racerClassId] = $this->explodeNumberClass($racerNumberClass);
            [$racerBranchId, $racerBirthplaceId, $racerAge, $racerWeight] = $this->explodeBranchBirthplaceAgeWeight($racerBranchBirthplaceAgeWeight);
            [$racerFlyingCount, $racerLateCount, $racerAverageStartTiming] = $this->explodeFlyingLateStartTiming($racerFlyingLateStartTiming);
            [$racerNationalTop1Percent, $racerNationalTop2Percent, $racerNationalTop3Percent] = $this->explodeNationalTop123Percent($racerNationalTop123Percent);
            [$racerLocalTop1Percent, $racerLocalTop2Percent, $racerLocalTop3Percent] = $this->explodeLocalTop123Percent($racerLocalTop123Percent);
            [$racerAssignedMotorNumber, $racerAssignedMotorTop2Percent, $racerAssignedMotorTop3Percent] = $this->explodeAssignedMotorNumberMotorTop23Percent($racerAssignedMotorNumberMotorTop23Percent);
            [$racerAssignedBoatNumber, $racerAssignedBoatTop2Percent, $racerAssignedBoatTop3Percent] = $this->explodeAssignedBoatNumberBoatTop23Percent($racerAssignedBoatNumberBoatTop23Percent);

            $response['boats'][$racerBoatNumber]['racer_boat_number'] = $racerBoatNumber;
            $response['boats'][$racerBoatNumber]['racer_name'] = $racerName;
            $response['boats'][$racerBoatNumber]['racer_number'] = $racerNumber;
            $response['boats'][$racerBoatNumber]['racer_class_id'] = $racerClassId;
            $response['boats'][$racerBoatNumber]['racer_branch_id'] = $racerBranchId;
            $response['boats'][$racerBoatNumber]['racer_birthplace_id'] = $racerBirthplaceId;
            $response['boats'][$racerBoatNumber]['racer_age'] = $racerAge;
            $response['boats'][$racerBoatNumber]['racer_weight'] = $racerWeight;
            $response['boats'][$racerBoatNumber]['racer_flying_count'] = $racerFlyingCount;
            $response['boats'][$racerBoatNumber]['racer_late_count'] = $racerLateCount;
            $response['boats'][$racerBoatNumber]['racer_average_start_timing'] = $racerAverageStartTiming;
            $response['boats'][$racerBoatNumber]['racer_national_top_1_percent'] = $racerNationalTop1Percent;
            $response['boats'][$racerBoatNumber]['racer_national_top_2_percent'] = $racerNationalTop2Percent;
            $response['boats'][$racerBoatNumber]['racer_national_top_3_percent'] = $racerNationalTop3Percent;
            $response['boats'][$racerBoatNumber]['racer_local_top_1_percent'] = $racerLocalTop1Percent;
            $response['boats'][$racerBoatNumber]['racer_local_top_2_percent'] = $racerLocalTop2Percent;
            $response['boats'][$racerBoatNumber]['racer_local_top_3_percent'] = $racerLocalTop3Percent;
            $response['boats'][$racerBoatNumber]['racer_assigned_motor_number'] = $racerAssignedMotorNumber;
            $response['boats'][$racerBoatNumber]['racer_assigned_motor_top_2_percent'] = $racerAssignedMotorTop2Percent;
            $response['boats'][$racerBoatNumber]['racer_assigned_motor_top_3_percent'] = $racerAssignedMotorTop3Percent;
            $response['boats'][$racerBoatNumber]['racer_assigned_boat_number'] = $racerAssignedBoatNumber;
            $response['boats'][$racerBoatNumber]['racer_assigned_boat_top_2_percent'] = $racerAssignedBoatTop2Percent;
            $response['boats'][$racerBoatNumber]['racer_assigned_boat_top_3_percent'] = $racerAssignedBoatTop3Percent;
        }

        return $response;
    }

    /**
     * @param  string|null  $subtitleDistance
     * @return array
     */
    private function explodeSubtitleDistance(?string $subtitleDistance = null): array
    {
        if (is_null($subtitleDistance)) {
            return array_fill(0, 2, null);
        }

        $subtitleDistance = Converter::string($subtitleDistance);

        $values = array_filter(Trimmer::trim(explode(' ', $subtitleDistance)));
        $distance = Converter::int(array_pop($values));
        $subtitle = Converter::string(implode($values));

        return [$subtitle, $distance];
    }

    /**
     * @param  string|null  $numberClass
     * @return array
     */
    private function explodeNumberClass(?string $numberClass = null): array
    {
        if (is_null($numberClass)) {
            return array_fill(0, 2, null);
        }

        $numberClass = Converter::string($numberClass);

        [$number, $className] = Trimmer::trim(
            explode('/', $numberClass)
        );

        $number = Converter::int($number);
        $classId = Converter::classId($className);

        return [$number, $classId];
    }

    /**
     * @param  string|null  $branchBirthplaceAgeWeight
     * @return array
     */
    private function explodeBranchBirthplaceAgeWeight(?string $branchBirthplaceAgeWeight = null): array
    {
        if (is_null($branchBirthplaceAgeWeight)) {
            return array_fill(0, 4, null);
        }

        $branchBirthplaceAgeWeight = Converter::string($branchBirthplaceAgeWeight);

        [$branchNameBirthplaceName, $ageWeight] = Trimmer::trim(explode(' ', $branchBirthplaceAgeWeight));
        [$branchName, $birthplaceName] = Trimmer::trim(explode('/', $branchNameBirthplaceName));
        [$age, $weight] = Trimmer::trim(explode('/', $ageWeight));

        $branchId = Converter::prefectureId($branchName);
        $birthplaceId = Converter::prefectureId($birthplaceName);
        $age = Converter::int($age);
        $weight = Converter::float($weight);

        return [$branchId, $birthplaceId, $age, $weight];
    }

    /**
     * @param  string|null  $flyingLateStartTiming
     * @return array
     */
    private function explodeFlyingLateStartTiming(?string $flyingLateStartTiming = null): array
    {
        if (is_null($flyingLateStartTiming)) {
            return array_fill(0, 3, null);
        }

        $flyingLateStartTiming = Converter::string($flyingLateStartTiming);

        [$flyingCount, $lateCount, $averageStartTiming] = Trimmer::trim(
            explode(' ', $flyingLateStartTiming)
        );

        $flyingCount = Converter::flying($flyingCount);
        $lateCount = Converter::late($lateCount);
        $averageStartTiming = Converter::startTiming($averageStartTiming);

        return [$flyingCount, $lateCount, $averageStartTiming];
    }

    /**
     * @param  string|null  $nationalTop123Percent
     * @return array
     */
    private function explodeNationalTop123Percent(?string $nationalTop123Percent = null): array
    {
        if (is_null($nationalTop123Percent)) {
            return array_fill(0, 3, null);
        }

        $nationalTop123Percent = Converter::string($nationalTop123Percent);

        [$nationalTop1Percent, $nationalTop2Percent, $nationalTop3Percent] = Trimmer::trim(
            explode(' ', $nationalTop123Percent)
        );

        $nationalTop1Percent = Converter::float($nationalTop1Percent);
        $nationalTop2Percent = Converter::float($nationalTop2Percent);
        $nationalTop3Percent = Converter::float($nationalTop3Percent);

        return [$nationalTop1Percent, $nationalTop2Percent, $nationalTop3Percent];
    }

    /**
     * @param  string|null  $localTop123Percent
     * @return array
     */
    private function explodeLocalTop123Percent(?string $localTop123Percent = null): array
    {
        if (is_null($localTop123Percent)) {
            return array_fill(0, 3, null);
        }

        $localTop123Percent = Converter::string($localTop123Percent);

        [$localTop1Percent, $localTop2Percent, $localTop3Percent] = Trimmer::trim(
            explode(' ', $localTop123Percent)
        );

        $localTop1Percent = Converter::float($localTop1Percent);
        $localTop2Percent = Converter::float($localTop2Percent);
        $localTop3Percent = Converter::float($localTop3Percent);

        return [$localTop1Percent, $localTop2Percent, $localTop3Percent];
    }

    /**
     * @param  string|null  $assignedMotorNumberMotorTop23Percent
     * @return array
     */
    private function explodeAssignedMotorNumberMotorTop23Percent(?string $assignedMotorNumberMotorTop23Percent = null): array
    {
        if (is_null($assignedMotorNumberMotorTop23Percent)) {
            return array_fill(0, 3, null);
        }

        $assignedMotorNumberMotorTop23Percent = Converter::string($assignedMotorNumberMotorTop23Percent);

        [$assignedMotorNumber, $assignedMotorTop2Percent, $assignedMotorTop3Percent] = Trimmer::trim(
            explode(' ', $assignedMotorNumberMotorTop23Percent)
        );

        $assignedMotorNumber = Converter::int($assignedMotorNumber);
        $assignedMotorTop2Percent = Converter::float($assignedMotorTop2Percent);
        $assignedMotorTop3Percent = Converter::float($assignedMotorTop3Percent);

        return [$assignedMotorNumber, $assignedMotorTop2Percent, $assignedMotorTop3Percent];
    }

    /**
     * @param  string|null  $assignedBoatNumberBoatTop23Percent
     * @return array
     */
    private function explodeAssignedBoatNumberBoatTop23Percent(?string $assignedBoatNumberBoatTop23Percent = null): array
    {
        if (is_null($assignedBoatNumberBoatTop23Percent)) {
            return array_fill(0, 3, null);
        }

        $assignedBoatNumberBoatTop23Percent = Converter::string($assignedBoatNumberBoatTop23Percent);

        [$assignedBoatNumber, $assignedBoatTop2Percent, $assignedBoatTop3Percent] = Trimmer::trim(
            explode(' ', $assignedBoatNumberBoatTop23Percent)
        );

        $assignedBoatNumber = Converter::int($assignedBoatNumber);
        $assignedBoatTop2Percent = Converter::float($assignedBoatTop2Percent);
        $assignedBoatTop3Percent = Converter::float($assignedBoatTop3Percent);

        return [$assignedBoatNumber, $assignedBoatTop2Percent, $assignedBoatTop3Percent];
    }
}
