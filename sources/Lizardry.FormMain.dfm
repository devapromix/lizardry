object FormMain: TFormMain
  Left = 0
  Top = 0
  Caption = 'Lizardry'
  ClientHeight = 712
  ClientWidth = 1184
  Color = clBtnFace
  Constraints.MinHeight = 750
  Constraints.MinWidth = 1200
  Font.Charset = DEFAULT_CHARSET
  Font.Color = clWindowText
  Font.Height = -11
  Font.Name = 'Tahoma'
  Font.Style = []
  OldCreateOrder = False
  ShowHint = True
  WindowState = wsMaximized
  OnCreate = FormCreate
  OnResize = FormResize
  OnShow = FormShow
  PixelsPerInch = 96
  TextHeight = 13
  inline FrameLogin: TFrameLogin
    Left = 0
    Top = 0
    Width = 1184
    Height = 693
    Align = alClient
    Font.Charset = RUSSIAN_CHARSET
    Font.Color = clWindowText
    Font.Height = -19
    Font.Name = 'Courier New'
    Font.Style = []
    ParentFont = False
    TabOrder = 0
    ExplicitWidth = 1184
    ExplicitHeight = 693
    inherited Panel1: TPanel
      Height = 693
      ExplicitHeight = 693
      inherited CurrentClientVersion: TLabel
        Top = 676
        ExplicitTop = 676
      end
    end
    inherited Panel2: TPanel
      Width = 934
      Height = 693
      ExplicitWidth = 934
      ExplicitHeight = 693
      inherited Panel3: TPanel
        Width = 934
        ExplicitWidth = 934
        inherited Image1: TImage
          Width = 934
          ExplicitWidth = 734
          ExplicitHeight = 487
        end
      end
      inherited Panel4: TPanel
        Width = 924
        Height = 468
        ExplicitWidth = 924
        ExplicitHeight = 468
        inherited Label3: TLabel
          Width = 924
        end
        inherited Panel5: TPanel
          Width = 924
          ExplicitWidth = 924
        end
        inherited StaticText1: TStaticText
          Width = 924
          Height = 426
          ExplicitWidth = 924
          ExplicitHeight = 426
        end
      end
      inherited Panel6: TPanel
        Height = 468
        ExplicitHeight = 468
      end
    end
  end
  inline FrameRegistration: TFrameRegistration
    Left = 0
    Top = 0
    Width = 1184
    Height = 693
    Align = alClient
    Font.Charset = RUSSIAN_CHARSET
    Font.Color = clWindowText
    Font.Height = -19
    Font.Name = 'Courier New'
    Font.Style = []
    ParentFont = False
    TabOrder = 1
    ExplicitWidth = 1184
    ExplicitHeight = 693
    inherited Panel1: TPanel
      Height = 693
      ExplicitHeight = 693
    end
    inherited Panel2: TPanel
      Width = 934
      Height = 693
      ExplicitWidth = 934
      ExplicitHeight = 693
      inherited Panel3: TPanel
        Width = 934
        ExplicitWidth = 934
        inherited Image1: TImage
          Width = 934
          ExplicitWidth = 734
          ExplicitHeight = 487
        end
      end
      inherited Panel4: TPanel
        Width = 934
        Height = 468
        ExplicitWidth = 934
        ExplicitHeight = 468
      end
    end
  end
  inline FrameTown: TFrameTown
    Left = 0
    Top = 0
    Width = 1184
    Height = 693
    Align = alClient
    Font.Charset = RUSSIAN_CHARSET
    Font.Color = clWindowText
    Font.Height = -19
    Font.Name = 'Courier New'
    Font.Style = []
    ParentFont = False
    TabOrder = 2
    ExplicitWidth = 1184
    ExplicitHeight = 693
    inherited RightPanel: TPanel
      Left = 904
      Height = 693
      ExplicitLeft = 904
      ExplicitHeight = 693
    end
    inherited LeftPanel: TPanel
      Height = 693
      ExplicitHeight = 693
    end
    inherited MainPanel: TPanel
      Width = 604
      Height = 693
      ExplicitWidth = 604
      ExplicitHeight = 693
      inherited FrameChar: TFrameChar
        Width = 604
        Height = 468
        ExplicitWidth = 604
        ExplicitHeight = 468
        inherited PageControl1: TPageControl
          Width = 604
          Height = 468
          ExplicitWidth = 604
          ExplicitHeight = 468
          inherited TabSheet1: TTabSheet
            ExplicitWidth = 596
            ExplicitHeight = 432
          end
          inherited TabSheet2: TTabSheet
            ExplicitWidth = 596
            ExplicitHeight = 432
            inherited SG: TStringGrid
              Width = 596
              Height = 343
              ExplicitWidth = 596
              ExplicitHeight = 343
            end
            inherited Panel1: TPanel
              Width = 596
              ExplicitWidth = 596
            end
            inherited Panel2: TPanel
              Top = 368
              Width = 596
              ExplicitTop = 368
              ExplicitWidth = 596
              inherited ttInfo: TLabel
                Width = 594
                ExplicitWidth = 614
              end
            end
          end
        end
      end
      inherited Panel10: TPanel
        Width = 604
        ExplicitWidth = 604
      end
      inherited FramePanel: TPanel
        Top = 493
        Width = 604
        ExplicitTop = 493
        ExplicitWidth = 604
        inherited FrameBank1: TFrameBank
          Width = 602
          ExplicitWidth = 602
        end
        inherited FrameDefault1: TFrameDefault
          Width = 602
          ExplicitWidth = 602
        end
        inherited FrameTavern1: TFrameTavern
          Width = 602
          ExplicitWidth = 602
        end
        inherited FrameOutlands1: TFrameOutlands
          Width = 602
          ExplicitWidth = 602
        end
        inherited FrameLoot1: TFrameLoot
          Width = 602
          ExplicitWidth = 602
        end
        inherited FrameAfterBattle1: TFrameAfterBattle
          Width = 602
          ExplicitWidth = 602
        end
        inherited FrameBeforeBattle1: TFrameBeforeBattle
          Width = 602
          ExplicitWidth = 602
        end
        inherited FrameGetLoot1: TFrameGetLoot
          Width = 602
          ExplicitWidth = 602
        end
      end
      inherited Panel19: TPanel
        Width = 604
        Height = 468
        ExplicitWidth = 604
        ExplicitHeight = 468
        inherited FrameShop1: TFrameShop
          Width = 602
          Height = 466
          ExplicitWidth = 602
          ExplicitHeight = 466
          inherited SG: TStringGrid
            Width = 602
            ExplicitWidth = 602
          end
          inherited Panel1: TPanel
            Width = 602
            ExplicitWidth = 602
            inherited Label1: TLabel
              Width = 602
              ExplicitWidth = 622
            end
          end
          inherited Panel2: TPanel
            Width = 602
            ExplicitWidth = 602
            inherited ttInfo: TLabel
              Width = 600
              ExplicitWidth = 600
            end
          end
        end
        inherited FrameInfo1: TFrameInfo
          Width = 602
          Height = 466
          ExplicitWidth = 602
          ExplicitHeight = 466
          inherited StaticText2: TStaticText
            Top = 332
            Width = 602
            ExplicitTop = 332
            ExplicitWidth = 602
          end
          inherited StaticText1: TStaticText
            Width = 602
            Height = 332
            ExplicitWidth = 602
            ExplicitHeight = 332
          end
        end
        inherited FrameBattle1: TFrameBattle
          Width = 602
          Height = 466
          ExplicitWidth = 602
          ExplicitHeight = 466
          inherited Panel1: TPanel
            Width = 602
            Height = 306
            ExplicitWidth = 602
            ExplicitHeight = 306
            inherited BattleLog: TRichEdit
              Width = 600
              Height = 304
              ExplicitWidth = 600
              ExplicitHeight = 304
            end
          end
          inherited Panel2: TPanel
            Width = 602
            ExplicitWidth = 602
            inherited Panel3: TPanel
              Left = 265
              ExplicitLeft = 265
            end
          end
        end
      end
    end
  end
  inline FrameUpdate: TFrameUpdate
    Left = 0
    Top = 0
    Width = 1184
    Height = 693
    Align = alClient
    TabOrder = 3
    ExplicitWidth = 1184
    ExplicitHeight = 693
    inherited Panel1: TPanel
      Height = 693
      ExplicitHeight = 693
      inherited bbOpenSite: TBitBtn
        OnClick = FrameUpdatebbOpenSiteClick
      end
    end
    inherited Panel2: TPanel
      Width = 934
      Height = 693
      ExplicitWidth = 934
      ExplicitHeight = 693
      inherited ttInfo: TLabel
        Width = 934
      end
      inherited ttUpdate: TLabel
        Width = 934
      end
      inherited Panel3: TPanel
        Width = 934
        ExplicitWidth = 934
        inherited Image1: TImage
          Width = 934
          ExplicitWidth = 932
        end
      end
    end
  end
  object StatusBar: TStatusBar
    Left = 0
    Top = 693
    Width = 1184
    Height = 19
    Panels = <>
    SimplePanel = True
  end
end
