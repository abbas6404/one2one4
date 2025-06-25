"use client"

import { useState } from "react"
import { Button } from "@/components/ui/button"
import { Card, CardContent, CardDescription, CardFooter, CardHeader, CardTitle } from "@/components/ui/card"
import { RadioGroup, RadioGroupItem } from "@/components/ui/radio-group"
import { Label } from "@/components/ui/label"

export default function EligibilityCheck() {
  const [step, setStep] = useState(1)
  const [answers, setAnswers] = useState({
    age: "",
    weight: "",
    health: "",
    medication: "",
  })
  const [result, setResult] = useState<string | null>(null)

  const handleChange = (field: string, value: string) => {
    setAnswers({ ...answers, [field]: value })
  }

  const handleNext = () => {
    if (step < 4) {
      setStep(step + 1)
    } else {
      // Evaluate eligibility
      if (
        answers.age === "yes" &&
        answers.weight === "yes" &&
        answers.health === "yes" &&
        answers.medication === "no"
      ) {
        setResult("eligible")
      } else {
        setResult("ineligible")
      }
    }
  }

  const handleReset = () => {
    setStep(1)
    setAnswers({
      age: "",
      weight: "",
      health: "",
      medication: "",
    })
    setResult(null)
  }

  const questions = [
    {
      field: "age",
      question: "Are you between 17 and 65 years old?",
    },
    {
      field: "weight",
      question: "Do you weigh at least 110 pounds (50kg)?",
    },
    {
      field: "health",
      question: "Are you in good general health?",
    },
    {
      field: "medication",
      question: "Are you currently taking any antibiotics or other medications for an infection?",
    },
  ]

  const currentQuestion = questions[step - 1]

  return (
    <section className="py-16 bg-white">
      <div className="container mx-auto px-4">
        <div className="max-w-2xl mx-auto text-center mb-12">
          <h2 className="text-3xl font-bold mb-4">Check Your Eligibility</h2>
          <p className="text-gray-600">
            Answer a few quick questions to see if you're eligible to donate blood today. This is just a preliminary
            check - a full assessment will be done at the donation center.
          </p>
        </div>

        <Card className="max-w-md mx-auto">
          {result === null ? (
            <>
              <CardHeader>
                <CardTitle>Question {step} of 4</CardTitle>
                <CardDescription>{currentQuestion.question}</CardDescription>
              </CardHeader>
              <CardContent>
                <RadioGroup
                  value={answers[currentQuestion.field as keyof typeof answers]}
                  onValueChange={(value) => handleChange(currentQuestion.field, value)}
                >
                  <div className="flex items-center space-x-2 mb-4">
                    <RadioGroupItem value="yes" id={`${currentQuestion.field}-yes`} />
                    <Label htmlFor={`${currentQuestion.field}-yes`}>Yes</Label>
                  </div>
                  <div className="flex items-center space-x-2">
                    <RadioGroupItem value="no" id={`${currentQuestion.field}-no`} />
                    <Label htmlFor={`${currentQuestion.field}-no`}>No</Label>
                  </div>
                </RadioGroup>
              </CardContent>
              <CardFooter>
                <Button
                  onClick={handleNext}
                  disabled={!answers[currentQuestion.field as keyof typeof answers]}
                  className="w-full bg-red-600 hover:bg-red-700"
                >
                  {step === 4 ? "Check Eligibility" : "Next Question"}
                </Button>
              </CardFooter>
            </>
          ) : (
            <>
              <CardHeader>
                <CardTitle>
                  {result === "eligible"
                    ? "Great news! You may be eligible to donate."
                    : "You may not be eligible at this time."}
                </CardTitle>
              </CardHeader>
              <CardContent>
                <p className="mb-4">
                  {result === "eligible"
                    ? "Based on your answers, you appear to meet the basic eligibility requirements for blood donation."
                    : "Based on your answers, you may not be eligible to donate blood at this time."}
                </p>
                <p className="text-sm text-gray-500">
                  Note: This is only a preliminary check. The donation center will conduct a thorough health screening
                  before your donation.
                </p>
              </CardContent>
              <CardFooter className="flex flex-col sm:flex-row gap-3">
                <Button onClick={handleReset} variant="outline" className="w-full sm:w-auto">
                  Start Over
                </Button>
                {result === "eligible" && (
                  <Button className="w-full sm:w-auto bg-red-600 hover:bg-red-700">Schedule Appointment</Button>
                )}
              </CardFooter>
            </>
          )}
        </Card>
      </div>
    </section>
  )
}
