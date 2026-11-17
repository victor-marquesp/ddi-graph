
import csv
import json
import random
import argparse
import re

from pathlib import Path
from collections import defaultdict


# ==========================================
# CONFIGURATION
# ==========================================

ROOT_DIR = Path(__file__).resolve().parent.parent

RAW_DIR = ROOT_DIR / "database/datasets/raw"
OUTPUT_DIR = ROOT_DIR / "database/datasets/processed"

SEED = 42

VALID_SEVERITIES = {"Minor", "Moderate", "Major"}


# ==========================================
# DATA EXTRACTION
# ==========================================

def load_ddinter():

    drugs = {}
    interactions = {}
    conflicts = set()

    files = sorted(RAW_DIR.glob("ddinter_downloads_*.csv"))

    if not files:
        raise FileNotFoundError("DDInter CSV files not found.")

    for path in files:

        print(f"Reading {path.name}...")

        with path.open(encoding="utf-8-sig") as file:

            for row in csv.DictReader(file):

                a = row["DDInterID_A"].strip()
                b = row["DDInterID_B"].strip()

                severity = row["Level"].strip()

                drugs[a] = row["Drug_A"].strip()
                drugs[b] = row["Drug_B"].strip()

                if a == b:
                    continue

                if severity not in VALID_SEVERITIES:
                    continue

                pair = tuple(sorted((a, b)))

                if pair in interactions:

                    if interactions[pair] != severity:
                        conflicts.add(pair)

                else:
                    interactions[pair] = severity

    for pair in conflicts:
        interactions.pop(pair, None)

    print(f"Original drugs: {len(drugs)}")
    print(f"Valid interactions: {len(interactions)}")
    print(f"Conflicting interactions: {len(conflicts)}")

    return drugs, interactions


def load_mapping():

    with (RAW_DIR / "drug_data.json").open(
        encoding="utf-8"
    ) as file:

        data = json.load(file)

    return {
        f"DDInter{record['ddinter']}": record["drugbank"]
        for record in data["records"]
        if record.get("drugbank")
    }


def load_atc_codes():

    with (RAW_DIR / "drugs_list.json").open(
        encoding="utf-8"
    ) as file:

        data = json.load(file)

    codes = defaultdict(set)

    for record in data:

        drugbank_id = record.get("drugbank_id")
        atc_code = record.get("atc_code")

        if not drugbank_id or not atc_code:
            continue

        atc_code = atc_code.strip().upper()

        if not re.fullmatch(r"[A-Z]\d{2}[A-Z]{2}\d{2}", atc_code):
            continue

        codes[drugbank_id].add(atc_code)

    return codes


def load_classifications():

    with (RAW_DIR / "drugs_atc.json").open(
        encoding="utf-8"
    ) as file:

        data = json.load(file)

    classifications = {}

    for group in data["classes"]:

        for subgroup in group.get("children", []):

            code = subgroup["atc_code"]
            name = subgroup["name"]

            if not re.fullmatch(r"[A-Z]\d{2}", code):
                continue

            name = name.removesuffix(f" ({code})")

            classifications[code] = {
                "code": code,
                "name": name,
                "description": None
            }

    return classifications


# ==========================================
# DATA TRANSFORMATION
# ==========================================

def normalize_drugs(drugs, mapping, atc_codes, classifications):

    result = {}

    missing_mapping = 0
    missing_atc = 0
    ambiguous_atc = 0
    missing_classification = 0

    for drug_id, name in drugs.items():

        drugbank_id = mapping.get(drug_id)

        if not drugbank_id:
            missing_mapping += 1
            continue

        codes = atc_codes.get(drugbank_id, set())

        if not codes:
            missing_atc += 1
            continue

        groups = {code[:3] for code in codes}

        if len(groups) != 1:
            ambiguous_atc += 1
            continue

        classification_code = next(iter(groups))

        if classification_code not in classifications:
            missing_classification += 1
            continue

        result[drug_id] = {
            "external_id": drug_id,
            "name": name,
            "description": None,
            "classification_code": classification_code
        }

    print("\nNormalization results:")
    print(f"Missing DrugBank mapping: {missing_mapping}")
    print(f"Missing ATC codes: {missing_atc}")
    print(f"Ambiguous ATC groups: {ambiguous_atc}")
    print(f"Missing classification: {missing_classification}")
    print(f"Eligible drugs: {len(result)}")

    return result


def select_drugs(drugs, limit):

    if limit is None:
        return drugs

    selected = random.Random(SEED).sample(
        sorted(drugs),
        min(limit, len(drugs))
    )

    return {
        drug_id: drugs[drug_id]
        for drug_id in selected
    }


def select_interactions(interactions, drugs):

    return [
        {
            "drug_a": a,
            "drug_b": b,
            "severity": severity,
            "description": None
        }
        for (a, b), severity in sorted(interactions.items())
        if a in drugs and b in drugs
    ]


def select_classifications(classifications, drugs):

    codes = {
        drug["classification_code"]
        for drug in drugs.values()
    }

    return [
        classifications[code]
        for code in sorted(codes)
    ]


# ==========================================
# DATA EXPORT
# ==========================================

def export_csv(filename, fields, records):

    OUTPUT_DIR.mkdir(parents=True, exist_ok=True)

    with (OUTPUT_DIR / filename).open(
        "w", newline="", encoding="utf-8"
    ) as file:

        writer = csv.DictWriter(
            file,
            fieldnames=fields
        )

        writer.writeheader()
        writer.writerows(records)


# ==========================================
# MAIN
# ==========================================

def main():

    parser = argparse.ArgumentParser()

    parser.add_argument("--limit", type=int, default=None)

    args = parser.parse_args()

    if args.limit is not None and args.limit <= 0:
        parser.error("--limit must be positive")

    drugs, interactions = load_ddinter()

    mapping = load_mapping()
    atc_codes = load_atc_codes()
    classifications = load_classifications()

    drugs = normalize_drugs(
        drugs,
        mapping,
        atc_codes,
        classifications
    )

    if not drugs:
        raise RuntimeError("No eligible drugs found.")

    drugs = select_drugs(drugs, args.limit)

    interactions = select_interactions(
        interactions,
        drugs
    )

    classifications = select_classifications(
        classifications,
        drugs
    )

    export_csv(
        "classifications.csv",
        ["code", "name", "description"],
        classifications
    )

    export_csv(
        "drugs.csv",
        ["external_id", "name", "description", "classification_code"],
        drugs.values()
    )

    export_csv(
        "interactions.csv",
        ["drug_a", "drug_b", "severity", "description"],
        interactions
    )

    print("\nExtraction completed.")
    print(f"Classifications: {len(classifications)}")
    print(f"Drugs: {len(drugs)}")
    print(f"Interactions: {len(interactions)}")


if __name__ == "__main__":
    main()

