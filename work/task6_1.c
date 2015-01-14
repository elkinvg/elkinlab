{
//=========Macro generated from canvas: t0/
//=========  (Mon Jan  7 09:29:03 2013) by ROOT version5.24/00
   TCanvas *t0 = new TCanvas("t0", "",0,0,700,500);
   gStyle->SetOptStat(0);
   gStyle->SetOptTitle(0);
   t0->SetHighLightColor(2);
   t0->Range(1.336313e+09,-4.357334,1.336529e+09,0.785095);
   t0->SetFillColor(10);
   t0->SetBorderSize(2);
   t0->SetLogy();
   t0->SetFrameFillColor(0);
   
   TH1 *Rate_classA_5 = new TH1D("Rate_classA_5","Rate_classA_5",1,1.336334e+09,1.336507e+09);
   Rate_classA_5->SetBinContent(1,1.435188);
   Rate_classA_5->SetBinError(1,0.002881932);
   Rate_classA_5->SetMinimum(0.0001435188);
   Rate_classA_5->SetMaximum(1.865744);
   Rate_classA_5->SetEntries(247999);
   Rate_classA_5->SetStats(0);
   
   TF1 *cons = new TF1("cons","[0]",1.336334e+09,1.336507e+09);
   cons->SetBit(TF1::kNotDraw);
   cons->SetFillColor(10);
   cons->SetFillStyle(0);
   cons->SetLineWidth(3);
   cons->SetChisquare(6.048375e-18);
   cons->SetNDF(0);
   cons->SetParameter(0,1.435188);
   cons->SetParError(0,0.002881932);
   cons->SetParLimits(0,0,0);
   Rate_classA_5->GetListOfFunctions()->Add(cons);
   Rate_classA_5->SetLineColor(6);
   Rate_classA_5->SetLineWidth(2);
   Rate_classA_5->GetXaxis()->SetTitle("Time (UTC)");
   Rate_classA_5->GetXaxis()->SetTimeDisplay(1);
   Rate_classA_5->GetXaxis()->SetTimeFormat("%d %b%F1970-01-01 00:00:00 GMT");
   Rate_classA_5->GetXaxis()->SetNdivisions(507);
   Rate_classA_5->GetXaxis()->SetLabelSize(0.03);
   Rate_classA_5->GetYaxis()->SetTitle("Rate (class A,B), Hz");
   Rate_classA_5->Draw("hist");
   
   TH1 *Rate_classB_5 = new TH1D("Rate_classB_5","Rate_classB_5",1,1.336334e+09,1.336507e+09);
   Rate_classB_5->SetBinContent(1,0.06509876);
   Rate_classB_5->SetBinError(1,0.0006137842);
   Rate_classB_5->SetEntries(11249);
   Rate_classB_5->SetStats(0);
   
   TF1 *cons = new TF1("cons","[0]",1.336334e+09,1.336507e+09);
   cons->SetBit(TF1::kNotDraw);
   cons->SetFillColor(10);
   cons->SetFillStyle(0);
   cons->SetLineWidth(3);
   cons->SetChisquare(1.442402e-12);
   cons->SetNDF(0);
   cons->SetParameter(0,0.06509876);
   cons->SetParError(0,0.0006137842);
   cons->SetParLimits(0,0,0);
   Rate_classB_5->GetListOfFunctions()->Add(cons);
   Rate_classB_5->SetLineColor(6);
   Rate_classB_5->SetLineStyle(2);
   Rate_classB_5->SetLineWidth(2);
   Rate_classB_5->Draw("hist same");
   TText *text = new TText(0.5,0.94,"5");
   text->SetNDC();
   text->SetTextColor(6);
   text->Draw();
   text = new TText(0.05,0.94,"Stations: ");
   text->SetNDC();
   text->Draw();
   t0->Modified();
   t0->cd();
   t0->SetSelected(t0);
}
